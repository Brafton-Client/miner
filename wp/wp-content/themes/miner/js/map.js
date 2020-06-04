(function(){
    
    const map = {
        'states' : document.querySelectorAll('svg #line polygon'),
        'dataBox': { 
            'main' : document.getElementById('data-repo'),
            'state' : document.getElementById('state'),
            'icon' : document.getElementById('state-icon'),
            'locations' : document.getElementById('locations'),
        },
        'affiliate' : document.getElementById('affiliate'),
        'position' : null,
        'selection' : null,
        'activeStates': ['MS','NC','SC','NM','CA','ND','SD','UT','AZ','CO','TX','MN','IA','MO','KS','NE','AR','LA','TN','GA','FL'],
        'trueSourceStates' : ['NY','MT','WA','OR','ID','NV','WY','OK','WI','IL','MI','IN','OH','KY','PA','WV','VA','AL','NJ','MD','DE','VT','NH','ME','RI','CT','MA'],
        'groups': ['VA','MI'],
        'init' : (states)=> {
            for(let state of states) {
                if(map.activeStates.includes(state.getAttribute('id'))) {
                    state.addEventListener('click',(e)=> {
                        map.setPosition(e,map.dataBox.main);                        
                        map.dataBox.locations.innerHTML = "";
                        let abbrev = state.getAttribute('id');
                        map.removeActives();
                        map.toggleDataBox(map.dataBox.main,'hide','show');
                        map.toggleDataBox(map.affiliate,'show','hide');
                        map.append(abbrev);
                        state.classList.add('active');
                        map.selection = state.getAttribute('id');
                    });
                }  
                if(map.trueSourceStates.includes(state.getAttribute('id'))) {
                    state.addEventListener('click',(e)=> {
                        map.setPosition(e,map.affiliate);
                        map.removeActives();
                        map.toggleDataBox(map.dataBox.main,'show','hide');
                        state.classList.add('active');
                        map.toggleDataBox(map.affiliate,'hide','show');
                    });
                }  
                for(let item of map.groups) {
                    let odd = document.getElementById(item);
                    odd.addEventListener('click',(e)=> {
                        map.setPosition(e,map.affiliate);
                        map.removeActives();
                        map.toggleDataBox(map.dataBox.main,'show','hide');
                        let children = odd.children;
                        for(let child of children){
                            child.classList.add('active');
                        }
                        map.toggleDataBox(map.affiliate,'hide','show');
                    });
                }
            }
        },
        'append' : (state) => {
            map.dataBox.state.innerText = data[state].name;
            map.dataBox.icon.setAttribute('src',data[state].icon);
            map.setLocations(data[state].locations);
        },
        'setLocations' : (locations) => {
            for(let location of locations) {
                let phone = (location.phone === undefined) ? " " : ' | '+location.phone;
                var newCon = document.createElement('div');
                newCon.innerHTML += '<h3 class="location-title">'+location.title+'</h3>';
                newCon.innerHTML += '<p class="address-1">'+location.address_1+'</p>';
                newCon.innerHTML += '<p class="address-2">'+location.address_2+'</p>';
                newCon.innerHTML += '<div class="contact"><a href="mailto:'+location.email+'"><img class="mail-icon" src="https://new.minercorp.com/wp-content/uploads/2020/04/mail.jpg" alt="mail" /></a><a href="tel:'+phone+'" class="phone">'+phone+'</a></div>';
                map.dataBox.locations.append(newCon);
            }
        },
        'setPosition' : (event, elem) => {
            elem.style.left = (screen.width > 420) ? (event.pageX -550) +'px' : 0;
        },
        'toggleDataBox' : (elem,a,b) => {
            if(elem.classList.contains(a)){
                elem.classList.add(b);
                elem.classList.remove(a);
            }
        },
        'removeActives' : () => {
            if(document.querySelector('.active')) {
                let actives = document.getElementsByClassName('active');
                Array.from(actives).forEach((item)=>{
                    item.classList.remove('active');
                });
            }
        }
    }
    map.init(map.states);
    document.addEventListener('click',(e)=> {
        if(e.target.nodeName != 'polygon') {
            map.removeActives();
            if(document.querySelector('.show')) {
                document.querySelector('.show').classList.add('hide');
                document.querySelector('.show').classList.remove('show');
            }
        }
    });

}());