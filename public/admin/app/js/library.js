(function(w) {
    var d = w.document;
    w.addEventListener('load', function() {
        var expandir = d.getElementById('expandir');
        expandir.addEventListener('focus', function() {
            var menu = d.getElementById('menu-principal');
            menu.style.left = 0;
        });
        expandir.addEventListener('blur', function() {
            window.setTimeout(function() {
                var menu = d.getElementById('menu-principal');
                menu.style.left = '-320px';
            }, 200);
        });
    });
    
    w.conditional_redirect = function(e, addr, msg) {
        e.preventDefault();
        
        if (confirm(msg)) {
            w.location.href = addr
        }
    };
    
    w.check_all = function(headcheckbox) {
        var table = headcheckbox.parentNode.parentNode.parentNode.parentNode;
        var tbodies = table.getElementsByTagName('tbody');
        
        if (tbodies.length > 0) {
            var trs = tbodies[0].getElementsByTagName('tr');
            for (var i = 0; i < trs.length; i++) {
                var tds = trs[i].getElementsByTagName('td');
                if (tds.length) {
                    var inputs = tds[0].getElementsByTagName('input');
                    if (inputs.length && inputs[0].type == 'checkbox') {
                        inputs[0].checked = headcheckbox.checked;
                    }
                }
            }
        }
    }
    
    w.enviar_form = function(form, acao, e) {
        e.preventDefault();
        
        var input = d.createElement('input');
        input.type = 'hidden';
        input.name = 'save';
        switch(acao) {
            case 'save':
                input.value = 'save';
            break;
            case 'savecontinue':
                input.value = 'continue';
            break;
        }
        form.appendChild(input);
        form.submit();
    }
    
    w.save_page = function(tr, type, e) {
        e.preventDefault();
        
        // Get the first parent form found.
        var form = tr.parentNode;
        while(form.nodeName != 'FORM') {
            form = form.parentNode;
        }
        // Get the first parent form found.
        
        var xhr = new XMLHttpRequest;
        xhr.open('POST', form.action + '/bind', true);
        
        var elements = tr.querySelectorAll('td');
        var formData = new FormData;
        
        for (let i=0; i < elements.length; i++) {
            for (let j=0; j < elements[i].childNodes.length; j++) {
                console.log(elements[i].childNodes[j].name);
                if (elements[i].childNodes[j].name) {
                    elements[i].childNodes[j].disabled = true;
                    formData.append(elements[i].childNodes[j].name, elements[i].childNodes[j].value);
                }
            }
        }
        
        xhr.send(formData);
        
        xhr.onload = (function(tds, action) {
            return function() {
                var pageobj = JSON.parse(this.response);
                
                for(let i=0; i < tds.length; i++) {
                    while(tds[i].firstChild) {
                        tds[i].removeChild(tds[i].firstChild);
                    }
                }
                
                tds[0].innerHTML = pageobj.id;
                tds[1].innerHTML = pageobj.page ? pageobj.page : 'Todas';
                tds[2].innerHTML = pageobj.section;
                tds[3].innerHTML = pageobj.order;
                tds[4].innerHTML = pageobj.component;
                
                if (type === "categories") {
                    tds[5].innerHTML = pageobj.limit;
                    var a = tds[6].appendChild(document.createElement('a'));
                } else {
                    var a = tds[5].appendChild(document.createElement('a'));
                }
                
                a.href='#';
                a.innerHTML = 'Excluir';
                
                a.onclick = (function(id) {
                    return function() {
                        remove_page(this.parentNode.parentNode, form.action + '/unbind/' + id);
                    }
                }(pageobj.id));
            }
        }(elements, form.action));
    }
    
    w.remove_page = function(tr, address, e) {
        if (e) {
            e.preventDefault();
        }

        if (confirm('Confirma a exclusão deste registro?')) {
            var xhr = new XMLHttpRequest;
            
            xhr.open('GET', address, true);
            xhr.send();
            
            xhr.onload = (function(trow) {
                return function() {
                    if (!this.response) {
                        trow.parentNode.removeChild(trow);
                    } else {
                        alert('Erro ao excluir registro');
                        throw(this.response);
                    }
                }
            }(tr));
        }
    }
    
    w.add_row = function(tbody, e) {
        e.preventDefault();
        
        var pageTemplate = document.getElementById('page');
        if (!pageTemplate) {
            throw('no page template found');
        }
        
        var page = document.importNode(pageTemplate.content, true);
        tbody.appendChild(page);
    }
    
    w.remove_row = function(tr, e) {
        e.preventDefault();
        
        if (confirm('Confirma a exclusão desta linha?')) {
            tr.parentNode.removeChild(tr);
        }
    }
    
    w.fill_section_component = function(selct, type) {
        // Waiting message
        var tr = selct.parentNode.parentNode;
        
        var selectSection = tr.querySelector('.section select');
        selectSection.disabled = true;
        
        var selectComponent = tr.querySelector('.component select');
        selectComponent.disabled = true;
        
        var option = document.createElement('option');
        option.innerHTML = 'Aguarde...';
        
        while (selectSection.firstChild) {
            selectSection.removeChild(selectSection.firstChild);
        }
        
        selectSection.appendChild(document.importNode(option, true));
        
        while (selectComponent.firstChild) {
            selectComponent.removeChild(selectComponent.firstChild);
        }
        
        selectComponent.appendChild(document.importNode(option, true));
        // Waiting message
        
        // Doing http request to get the layout name.
        var xhr = new XMLHttpRequest();
        
        xhr.open('GET', '/admin/pages/xml', true);
        xhr.send();
        
        xhr.onload = (function(page, t, ss, sc) {
            return function() {
                var pageNode = this.responseXML.getElementById(page);

                var option = document.createElement('option');
                option.innerHTML = 'Selecione...';

                // Sections.
                ss.removeChild(ss.firstChild);
                ss.appendChild(document.importNode(option, true));
                
                var sections = pageNode.querySelectorAll('section');
                for (let i=0; i < sections.length; i++) {
                    let opt = ss.appendChild(document.createElement('option'));
                    
                    opt.value = sections[i].getAttribute('name');
                    opt.innerHTML = opt.value;
                }
                
                ss.disabled = false;
                // Sections.

                // Components.
                sc.removeChild(sc.firstChild);
                sc.appendChild(document.importNode(option, true));
                
                var components = pageNode.querySelectorAll(t + ' component');
                for (let i=0; i < components.length; i++) {
                    let opt = sc.appendChild(document.createElement('option'));
                    
                    opt.value = components[i].getAttribute('name');
                    opt.innerHTML = opt.value;
                }
                
                sc.disabled = false;
                // Components.
                
                var pageLayout = pageNode.getAttribute('layout');
            }
        }(selct.value, type, selectSection, selectComponent));
        // Doing http request to get the layout name.
    }
    
    w.link_externo_interno = function(interno_externo) {
        var label_interno, label_externo;
        var labels = document.getElementsByTagName('label');
        
        for (var i = 0; i < labels.length; i++) {
            if (labels[i].getAttribute('for') == 'i_href_select') {
                label_interno = labels[i]
            }
            if (labels[i].getAttribute('for') == 'i_href_input') {
                label_externo = labels[i]
            }
        }
        
        var select = d.getElementById('i_href_select');
        var input = d.getElementById('i_href_input');
        
        if (interno_externo == "externo") {
            select.style.display = "none";
            select.disabled = true;
            input.style.display = "inline";
            input.disabled = false;
            label_interno.style.display = "none";
            label_externo.style.display = "inline-block";
        } else {
            select.style.display = "inline";
            select.disabled = false;
            input.style.display = "none";
            input.disabled = true;
            label_interno.style.display = "inline-block";
            label_externo.style.display = "none";
        }
    }
})(window);