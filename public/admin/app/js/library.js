(function(w) {
    console.log(w);
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