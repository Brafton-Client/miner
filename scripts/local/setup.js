var prompt = require('prompt');
var fs = require("fs");
var execGitCmd = require('run-git-command');
var rimraf = require('rimraf');

prompt.start();

var verifySchema = {
    properties: {
        bit: {
            description: "Have you setup a new empty repo on github? [(yes|y)|(no|n)]",
            type: 'string'
        }
    }
}

var createChild = function(name, parent){
    var meta = `
/******************************************************************
Theme Name: ${name}
Template: ${parent}
*/
`;
    fs.mkdir('wp/wp-content/themes/'+name,(er)=>{
        fs.writeFile('wp/wp-content/themes/'+name+'/style.css', meta, (er)=>{
            if(er){
                console.log("Couldn't create the style sheet for your child theme. You will need to do this manually");
                console.log(er);
            }
        })
    })
    // fs.writeFile('themes/'+name+'/style.css', meta, (er)=>{
    //     console.log(er);
    // })

}
// 
// Get two properties from the user: username and email 
// 
prompt.get(verifySchema, function (err, result) {

    var typeSchema = {
        properties: {
            type: {
                description: "Is this a templated build project? [(yes|y)|(no|n)]",
                required: true
            }
        }
    }
    prompt.get(typeSchema, (err, _result)=>{

        var isTemplated = _result.type.toLowerCase() == 'y' || _result.type.toLowerCase() == 'yes' ? true : false;
        if( result.bit.toLowerCase() == 'y' || result.bit.toLowerCase() == 'yes' ){
            // console.log("yes");
        }else{
            console.log("You must set up a new empty repo on bitbucket first before you can continue. Please see the readme file for instructions on how to do this.");
            return
        }
        var hermesSchema = {
            properties: {
                name: {
                    description: "Enter the clients Name: ",
                    pattern: /^[a-zA-Z\d_]*$/,
                    message: "Can not contain spaces or dashes. use underscores(_) for word seperation"
                },
                repo: {
                    description: "Enter the Repo name: "
                },
                title: {
                    description: "Enter the sites Title: "
                },
                username: {
                    description: "What is your github username?",
                    required: true
                },
                password: {
                    description: "What is your github password?",
                    required: true,
                    hidden: true
                }
            }
        }
        if(!isTemplated){
            hermesSchema.properties['parent'] = {   
                description: "If using a child theme what is the parent themes name: [Hit Enter if not using a parent/child theme]"
            }
        }
        prompt.get(hermesSchema, (err, res)=>{
            var pipeline = {
                "pipeline": {
                    "roleArn": "arn:aws:iam::868722408828:role/designs-dev-pipeline-role", 
                    "stages": [
                        {
                            "name": "Source", 
                            "actions": [
                                {
                                    "inputArtifacts": [], 
                                    "name": "Source", 
                                    "actionTypeId": {
                                        "category": "Source", 
                                        "owner": "AWS", 
                                        "version": "1", 
                                        "provider": "S3"
                                    }, 
                                    "outputArtifacts": [
                                        {
                                            "name": "source"
                                        }
                                    ], 
                                    "configuration": {
                                        "S3Bucket": "designs-dev-pipeline-artifacts", 
                                        "S3ObjectKey": "sites/Brafton-Client/{client}/site.zip"
                                    }, 
                                    "runOrder": 1
                                }
                            ]
                        }, 
                        {
                            "name": "Deploy", 
                            "actions": [
                                {
                                    "inputArtifacts": [
                                        {
                                            "name": "source"
                                        }
                                    ], 
                                    "name": "DeployEC2", 
                                    "actionTypeId": {
                                        "category": "Deploy", 
                                        "owner": "AWS", 
                                        "version": "1", 
                                        "provider": "CodeDeploy"
                                    }, 
                                    "outputArtifacts": [], 
                                    "configuration": {
                                        "ApplicationName": "designs-dev-site", 
                                        "DeploymentGroupName": "designs-dev-site"
                                    }, 
                                    "runOrder": 1
                                }
                            ]
                        }
                    ], 
                    "artifactStore": {
                        "type": "S3", 
                        "location": "designs-dev-pipeline-artifacts"
                    }, 
                    "name": "{clientName}}-designs-dev-pipeline", 
                    "version": 1
                }
            }
            var application = {
                applicationName: ""
            }
            var deployment_group = {
                "applicationName": "designs-dev-site",
                    "deploymentConfigName": "CodeDeployDefault.OneAtATime",
                    "ec2TagFilters": [
                        {
                            "Type": "KEY_AND_VALUE",
                            "Value": "designs-dev-site",
                            "Key": "app"
                        }
                    ],
                    "deploymentStyle": {
                        "deploymentType": "IN_PLACE",
                        "deploymentOption": "WITHOUT_TRAFFIC_CONTROL"
                    },
                    "serviceRoleArn": "arn:aws:iam::868722408828:role/designs-dev-pipeline-role",
                    "deploymentGroupName": "designs-dev-site",
            };            
            var jsoncontent = {
                "name": "",
                "account": "braftonclientsites",
                "repo": "",
                "global": {
                    "targetroot": "/var/www/html/design/brafton/${NAME}",
                    "group": "www",
                    "owner": "apache",
                    "url": "http://design.brafton.com/${NAME}",
                    "title": "",
                    "theme": "",
                    "parent": "",
                    "deploy_parent": "n",
                    "deployment_branch": "develop",
                    "deploy_plugins": "y",
                    "update_plugins": "n",
                    "package_site": "n",
                    "soft_launch_url": "",
                    "deploy_new_submodules": "n"
                },
                "deploy": [
                    {
                        "tag": "dev",
                        "branch": "${GLOBAL_DEPLOYMENT_BRANCH}",
                        "beforeinstall": "scripts/server/before.sh",
                        "afterinstall": "scripts/server/after.sh",
                        "source": "wp/wp-content/themes/${GLOBAL_THEME}",
                        "target": "${GLOBAL_TARGETROOT}/wp-content/themes/${GLOBAL_THEME}"
                    }
                ]
            };
            var env = `
            export NAME="${res.name}"
            export TITLE="${res.title}"
            export GLOBAL_OWNER="ec2-user"
            export GLOBAL_GROUP="apache"
            `;

            var appspec = `
version: 0.0
os: linux
files:
    - source: /themes/
      destination: /var/www/html/${res.name}/wp-content/themes
    - source: /plugins/
      destination: /var/www/html/${res.name}/wp-content/plugins
hooks:
    BeforeInstall:
    - location: scripts/before.sh
    AfterInstall:
    - location: scripts/after.sh`;
            jsoncontent.name = res.name;
            
            jsoncontent.repo = res.repo;
            jsoncontent.global.title = res.title;
            jsoncontent.global.theme = res.name;
            
            application.applicationName = `${res.name}-designs-dev-site`;

            deployment_group.deploymentGroupName = "designs-dev-site";
            deployment_group.applicationName = application.applicationName;

            pipeline.pipeline.name = res.name+"-designs-dev-pipeline";
            pipeline.pipeline.stages[0].actions[0].configuration.S3ObjectKey = `sites/Brafton-Client/${res.name}/site.zip`;
            pipeline.pipeline.stages[1].actions[0].configuration.ApplicationName = application.applicationName;
            

            if(isTemplated){
                //delete the bones theme and create a child theme
                jsoncontent.global.parent = "braftonium";
                jsoncontent.global.deploy_parent = "y";
                createChild(res.name, "braftonium");
                rimraf("wp/wp-content/themes/bones",(er)=>{
                    if(er){
                        console.log("There was an error deleting the bones theme. You will need to do this manually");
                        console.log(er);
                    }
                })
            }else{
                execGitCmd(['rm', 'wp/wp-content/themes/braftonium']).then(res=>{
                    
                })
                .catch(er=>{
                    console.log("Could not remove the submodule braftonium from this project");
                    console.log(er);
                })
            }
            if(!isTemplated && res.parent != ""){
                jsoncontent.global.parent = res.parent;
                jsoncontent.global.deploy_parent = "y";
                createChild(res.name, res.parent);
                rimraf("themes/bones",(er)=>{
                    if(er){
                        console.log("There was an error deleting the bones theme. You will need to do this manually");
                        console.log(er);
                    }
                })
                console.log("Before starting any work ensure your choosen parent theme is added the themes folder of this repo. NOTE: Even if you expect the theme to be already insatlled be sure to add to the repo for versioning");
            }else if(!isTemplated){
                fs.rename('wp/wp-content/themes/bones', 'wp/wp-content/themes/'+res.name, ()=>{
                    console.log("done");
                })
            }
            fs.writeFile('pipeline.json', JSON.stringify(pipeline, null, 4), er=>{
                if(er) console.log(er);
            })
            fs.writeFile('application.json', JSON.stringify(application, null, 4), er=>{
                if(er) console.log(er);
            })
            fs.writeFile('deployment-group.json', JSON.stringify(deployment_group, null, 4), er=>{
                if(er) console.log(er);
            })
            fs.writeFile('wp/wp-content/scripts/env.conf', env, er=>{
                if(er) console.log(er);
            })
            fs.writeFile('wp/wp-content/appspec.yml', appspec, er=>{
                if(er) console.log(er);
            })
            fs.writeFile('hermes.json', JSON.stringify(jsoncontent, null, 4),(er)=>{
                var pass = encodeURIComponent(res.password);
                execGitCmd(['remote','set-url', 'origin',`https://${res.username}:${pass}@github.com/brafton-client/${res.repo}`]).then(res=>{
                    execGitCmd(['add', '*']).then(res=>{
                        
                        execGitCmd(['commit', '-m', 'inital setup']).then(res=>{
                            
                            execGitCmd(['checkout', '--orphan', 'develop']).then(res=>{
                                execGitCmd(['add', '-A']).then(res=>{
                                    execGitCmd(['commit', '-m', 'New Site Build Initial setup']).then(res=>{
                                        execGitCmd(['push', 'origin','develop']).then(res=>{
                                            execGitCmd(['checkout', '-b', 'beta-build']).then(res=>{
                                                console.log("You are now working in the 'beta-build' branch.  Make changes to this branch and push those changes to bitbucket.  Merge your beta-build branch into your develop branch to deploy your changes to the remote server.  Happy Deving :-)");
                                                console.log("Initializing your submodules");
                                                execGitCmd(['submodule','update','--init','--recursive']).then(res=>{
                                                    console.log("Your submodules have been initialized");
                                                    execGitCmd(["submodule", "foreach", "git","checkout","master"]).then(res=>{
                                                        console.log(res);
                                                        execGitCmd(["submodule", "foreach", "git", "pull", "origin", "master"]).then(res=>{
                                                            console.log(res);
                                                            console.log("Your submodules are not up to date with their master branches");
                                                        }).catch(er=>{
                                                            console.log(er);
                                                            console.log("There was an error updating your submodules and syncing with its master branch.  run the following to complete this step. `git submodule foreach 'git checkout master && git pull origin master`");
                                                        })
                                                    }).catch(er=>{
                                                        console.log("There was an error updating your submodules and syncing with its master branch.  run the following to complete this step. `git submodule foreach 'git checkout master && git pull origin master`");
                                                        console.log(er);
                                                    })
                                                }).catch(er=>{
                                                    console.log("There was an error initializing your submodules. You must run the following command 'git submodule update --init --recursive' manually, followed by git submodule foreach 'git checkout master && git pull origin master'");
                                                    console.log(er);
                                                })
                                                fs.unlink(__filename, (er)=>{
                                                    console.log(er);
                                                });
                                            }).catch(er=>{
                                                console.log("There was an error creating your beta-build branch");
                                                console.log(er);
                                            })
                                        }).catch(er=>{
                                            console.log("There was an error pushing your default develop branch to the repo.")
                                            console.log(er);
                                        })
                                    }).catch(er=>{
                                        console.log("There was an error commiting the files to your new repo. Perform a commit and push mnually");
                                        console.log(er);
                                    })
                                }).catch(er=>{
                                    console.log("There was an adding your files to the new branch. You will need to do a git add -A and push manually ");
                                    console.log(er);
                                })

                            }).catch(er=>{
                                console.log("There was an error setting up a develop branch for you to start working in. When you are ready perform a 'git push origin develop'")
                                console.log(er);
                            })

                        }).catch(er=>{
                            console.log("There was an error making the inital commit for setup");
                            console.log(er);
                        })
                    }).catch(er=>{
                        console.log("There was an error adding your file changes");
                        console.log(er);
                    })
                }).catch(er=>{
                    console.log("There was an error setting the new origin for this repo.  Did you fib?  did you create a repo in bitbucket already?");
                    console.log(er);
                })
            });
    
        })    
    })
    
});