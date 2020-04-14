# Brafton Website Redeisgns
The following is instructions on the workflow for build clients sites.

# Project Setup  
> Step 1 and 2 below are for creation and setup of a brand new project. Skip to step 3 if working on an existing project.
## Step 1: Create the client repository

- Create a new repository on github for your new site build project
    - organizatoin: "brafton-client" https://github.com/Brafton-Client
    - Respository Name: {ClientName} [note: There can be no spaces or dashes. Use underscores(_) for word seperation]
    - Click Settings -> Secrets
        - Setup Secrets for AWS_ACCESS_KEY_ID, and AWS_SECRET_ACCESS_KEY both of which can be found in passshack

## Step 2: Modify repository for client

- clone this repository ` git clone https://github.com/brafton-client/basebuild {clientName}` to your local computer
- inside your new folder run the following commands `npm install `, `npm run setup`.
- Answer the prompts. Here is what will happen
    - You will be asked if you have completed step 1. THIS IS SUPER IMPORTANT. YOU MUST COMPLETE STEP ONE!!!!!!!!!
    - You will be asked if this is a templated build project.
        - If it is, bones theme will be deleted and a child theme for the "braftonium" will be created.
        - If it is not the braftonium will be removed and the bones theme will be renamed appropriately
    - You will be asked the clients name (this needs to contain no spaces or special characters.);
    - You will be asked the repo name you created in step one.
    - You will be asked a title for the new wordpress site
    - You will be asked your github username
    - You will be asked your github password
    - If this is a custom build it will ask you if you want to use a Parent theme. If you are using bones just hit enter.
    - the themes you need will be either created or remain while any uneeded themes will be deleted from the repo.
    - This folder will be automatically linked to your newley created repository on github
    - "develop" and "beta-build" branches will be created for you automatically and you will be switched over to the "beta-build" branch.
    - Initially you can perform your work in "beta-build" until you are ready to deploy to the development server.
    - Once you are doing your database work on designs.brafton.com you should than be using a branch named for what your working on and merge into "develop".  A detailed git workflow is detailed below.

## Step 3: Setup local dev enviorment
Local development uses docker and save all db_data to the repository for multiple developers to work on.
> If working on an existing project first clone the respository. The develop branch is the default master branch.  
> Your repository must be in your userpath in order to be able to mount the folders into the container

### First time setup on a machine.
- change directories into the project root folder.
- open .gitignore and find the line db_data and remove it. (only if you performed step 1 and 2)
- If you are continuing to work on the project you must also sync the submodules
- `git submodule update --init --recursive && git submodule foreach 'git checkout master && git pull origin master'`
- run `docker-compose up` to build the containers
- Once the up command finishes you can navigate to localhost:8000 to beging setting up wordpress. (Olnly if setting up a new project)
> Use admin for the username and password for the password
- You are now ready to develop locally.
> Be sure to: 
> - regularly commit your changes and push to github  
> - make small commits to allow for easier code review  

### Continued development.
Once the initial first time setup is completed to continue to work on the project follow the below steps.
- Start docker on yor machine.
- open a powershell window and navigate to the project root folder.
- run `docker-compose start` to start your containers and `docker-compose stop` to bring down your containers.
- Once the containers start you can then navigate to http://localhost:8000 to view the site.
> If you are met with the the wordpress installation if you are working on a project with an existing database you will need to stop your containers and restart docker. This occurs on occasion when the database container did not properly start before the wordpress container.  
> To prevent Database Conflicts be sure to properly shut down your containers and THEN commit your changes before finishing work for the day.  Correcting database file merges is no fun at all.

# Deploy to designs.brafton.com 
- During the setup process an AWS Pipeline will be created for you automatically and your dev site viewable at https://{clientName}.designs.brafton.com will be instantly available.
- Each push to your develop branch will cause a deployment to the dev server. 
> This deployment could take up to 10 minutes

> You should not be doing much database work on your local machine unless that work is easily exported and imported to the design server.  Your local development work should be focused on template and code work


## Step : Package your site up for deployment to the clients server.
- Activate the "Duplicator plugin".
- Navigate to Duplicator in the side menu and click "create new"
- Under 1-Setup you will see 3 tabs
    - Storage: which defaults to the location our snapshots are stored
    - Archive: which is details about the data. We need to make some modifications here
        1. Click on "Database"
        2. Click "Exclude All"
    - Installer: Provide some prefilled fields. We will just follow the prompts later for simplicity so we will ignore this tab.
- Click "Next"
- On 2-Scan we see a simply good, notice, error buttons. Ensure you have no errors and click the checkbox "Yes. Continue with the build process!" to continue clicking the "build" button.
- Once the build finishes you can choose the "one-click" download which will download 2 files
    - installer.php 
    - gobble-de-gook_clientName_more-gobble-de-gook_archive.zip
- Upload these 2 files to the clients server and navigate to the installer.php file.
- follow the prompts the finish the installtion.


# Git Workflow

Some general helpful tips
> Be sure to keep commits small and detailed.  
> describe each pull request to ensure proper history tracking  
> Use issues to create a list of items you need to work on or features you need to create.  

## Working on your project as the primary developer
When you initially setup your project you will have the following repos.
```
    develop
    beta-build
```
- develop: this branch will deploy your working theme to the development server. You should never push directly into this branch but rather create a pull request from your working branch and merge into develop.

- beta-build: this branch is your initial working branch for a new project.  You should be working in this branch until you are ready to create a deployment as outlined above to the development server.

Once the site is deployed to the development server you should no longer be working in beta-build but rather branch from develop. Use the naming convention "feature/patch-{your-name}-{what you are working on} for easy identification. 

To deploy to the development server create a pull request for your branch and merge into develop.
> be sure to remove the feature branch when you are done with it to keep the repo clean.

Once the site is soft-launched to the clients final server we still want to maintain the development server to be as close to the staging and live deployments as possible. for this we use the wp pusher plugin to deploy to the staging and live sites.  
### For Soft Launch (staging site)
From the develop branch create a "master-stg" (used to deploy to the staging environment) branch using the github UI. Follow the instructions using the wppusher plugins to link the theme to the repo master-stg branch.

Continue branching from develop using the naming convention "{feature/patch}-{your-name}-{what you are working on} for easy identification.

Create a pull request and merge from your feature/patch branch into develop to test on the development server. Create a new pull request and merge from develop into master-stg to deploy to the staging environment.

### For Live Launch (production site)

From the develop branch create a "master" (used to deploy to the production envirnoment) branch using the github GUI. Follow the instructions using the wppusher plugins to link the theme to the repo master branch.

Continue branching from develop using the naming convention "{feature/patch}-{your-name}-{what you are working on} for easy identification.

Create a pull request and merge from your feature/patch branch into develop to test on the development server. Create a new pull request and merge from develop into master to deploy to the production environment.

> If you are creating new features ideally you should merge first into master-stg to deploy your changes to staging to ensure there are no problems before also merging develop into master to deploy to production.

> The development enviorment may be removed sometime after the 30 day support window and as such deployment to design.brafton.com will not occur. You should still however never merge into master or master-stg from any branch other than develop!

## Command pallette
- `npm run setup` will setup the project folder
-  NEVER ADD PLUGINS VIA THE WORDPRESS INTERFACE: Add plugins on your local machine either through running local environment via the dashboard or by placing the unzipped folder into the plugins folder. (note you will need to create a pull request and merge the commit this command will push to github)
- This command is also required to deploy changes to the following submodules
    - BraftonWordpressPlugin - Content importer
    - Braftonium - Our Templated wordpress theme
    - Braftonium-plugin - our companion plugin required by Braftonium.

