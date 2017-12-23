var listahistorico = new Array();
var poshistorico = 0;

function ir(url, save) {
    try {
        var ajax = new XMLHttpRequest;
        ajax.open('POST','/file-manager.php',true);
        ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        ajax.save = save;
        ajax.url = url;
        ajax.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.save) salvahistorico(this.url);
                if (this.responseXML) {
                    montapasta(this.responseXML);
                } else {
                    mostramensagem('O retorno do servidor é inválido');
                }
                permissao(this.url);
            }
        }

        ajax.send('url=' + url);
    } catch(e) {
        alert('Error in the function "ir()" (' + e + ')');
    }
}

function novapasta() {
    var url = document.getElementById('navurl').value;
    var ajax = new XMLHttpRequest();
    ajax.open('POST','/file-manager.php',true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.responseXML) {
                montapasta(this.responseXML);
            } else {
                mostramensagem('O retorno do servidor é inválido');
            }
        }
    }
    ajax.send('url='+url+'&opt=1');
}

function excluir() {
    var pasta = document.getElementById('pasta');
    var url = document.getElementById('navurl').value;

    var lista = new Array();
    for (var i=0, j=0; pasta.childNodes[i]; i++) {
        if (/ui-selected/.test(pasta.childNodes[i].className)) {
            lista[j++] = pasta.childNodes[i].childNodes[1].firstChild.nodeValue;
        }
    }

    if (!lista.length) return;

    var mensagem = lista.length > 1 ? 'Tem certeza de que deseja excluir permanentemente estes ' + lista.length + ' itens?' : 'Tem certeza de que deseja excluir permanentemente este item?';
    if (!confirm(mensagem)) return;

    var ajax = new XMLHttpRequest();
    ajax.open('POST','/file-manager.php',true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.responseXML) {
                montapasta(this.responseXML);
            } else {
                mostramensagem('O retorno do servidor é inválido');
            }
        }
    }
    ajax.send('url='+url+'&opt=2&files='+lista.join(','));
}

function montapasta(xmld) {
    try {
        if (xmld.firstChild.nodeName == 'erro') {
            if (xmld.firstChild.firstChild) {
                throw(xmld.firstChild.firstChild.nodeValue);
            }
            
            throw('Ocorreu um erro ao executar a operação');
        }
        
        var pasta = document.getElementById('pasta');
        while (pasta.firstChild) pasta.removeChild(pasta.firstChild);

        var pastaobj = xmld.getElementsByTagName('pasta');
        if (pastaobj.length == 0) {
            return;
        }
        
        document.getElementById('navurl').value = pastaobj.item(0).getAttribute('url');
        document.getElementById('navurlhidden').value = document.getElementById('navurl').value;

        var diretorios = xmld.getElementsByTagName('diretorio');
        var arquivos = xmld.getElementsByTagName('arquivo');

        for (var i=0; diretorios[i]; i++) {
            var diretorio = diretorios[i];
            var divdiretorio = document.createElement('div');
            divdiretorio.className='diretorio';
            divdiretorio.appendChild(icone(diretorio.getAttribute('type')))
            var descricaodiretorio = document.createElement('div');
            descricaodiretorio.className = 'descricao';
            descricaodiretorio.appendChild(document.createTextNode(diretorio.getAttribute('name')));
            divdiretorio.appendChild(descricaodiretorio);

            descricaodiretorio.onclick = function() {
                if (this.firstChild.nodeName != 'INPUT') {
                    preparerename(this)
                }
            }

            divdiretorio.ondblclick = function() {
                ir(document.getElementById('navurl').value + this.childNodes[1].firstChild.nodeValue, 1) + '/';
            }

            pasta.appendChild(divdiretorio);
        }

        for (var i=0; arquivos[i]; i++) {
            var arquivo = arquivos[i];
            var divarquivo = document.createElement('div');
            divarquivo.className='arquivo';
            divarquivo.appendChild(icone(arquivo.getAttribute('type')))
            var descricaoarquivo = document.createElement('div');
            descricaoarquivo.className = 'descricao';
            descricaoarquivo.appendChild(document.createTextNode(arquivo.getAttribute('name')));
            descricaoarquivo.alt = arquivo.getAttribute('url') + '|' + arquivo.getAttribute('tamanho');
            divarquivo.appendChild(descricaoarquivo);

            descricaoarquivo.onclick = function() {
                if (this.firstChild.nodeName != 'INPUT') {
                    preparerename(this)
                }
            }

            divarquivo.onclick = function() {
                var informacoes = this.childNodes[1].alt.split('|');
                var status = document.getElementById('status');
                while (status.firstChild) status.removeChild(status.firstChild);
                for (var i=0; i < informacoes.length; i++) {
                    var div = document.createElement('div');
                    div.className = 'informacao';
                    div.appendChild(document.createTextNode(informacoes[i]));
                    status.appendChild(div);
                }
            }

            divarquivo.mime = arquivos[i].getAttribute('mime');
            divarquivo.name = arquivos[i].getAttribute('name');
            divarquivo.ondblclick = function() {
                if (this.mime == 'text/xml') {
                    var caminho = document.getElementById('navurl').value;
                    window.location.href = 'editorxml.php?file=' + caminho + this.name
                }
            }
            pasta.appendChild(divarquivo);
        }
        centralizadescricoes();
        var status = document.getElementById('status');
        while (status.firstChild) status.removeChild(status.firstChild);
    } catch(e) {
        mostramensagem(e);
        ir(document.getElementById('navurl').value,0);
    }
}

function mostramensagem(mensagem) {
    var divmensagem = document.getElementById('mensagem');
    while(divmensagem.firstChild) {
        divmensagem.removeChild(divmensagem.firstChild);
    }
    
    var diverro = document.createElement('div');
    diverro.className = 'erro';
    diverro.appendChild(document.createTextNode(mensagem));
    divmensagem.appendChild(diverro);
}

function salvahistorico(url) {
    if (listahistorico.length > 100) listahistorico.shift();
    poshistorico = listahistorico.length;
    listahistorico[listahistorico.length] = url;
}

function historico(p) {
    if (listahistorico[poshistorico+p]) {
        poshistorico += p
        ir(listahistorico[poshistorico], 0);
    }
}

function icone(type) {
    var icone = document.createElement('img');
    icone.className = 'icone'
    icone.src='/admin/components/file-manager/img/icone_'+type+'.png';
    return icone;
}

function centralizadescricoes() {
    var pasta = document.getElementById('pasta');
    for (var i=0; pasta.childNodes[i]; i++) {
        var height = pasta.childNodes[i].childNodes[1].offsetHeight;
        pasta.childNodes[i].childNodes[1].style.marginTop=((38-height)/2)+'px';
    }
}

function preparerename(objeto) {
    var nome = objeto.firstChild.nodeValue;
    var input = document.createElement('input');
    input.type='text';
    input.className = 'renameprepare';
    input.value = nome;
    input.alt = nome;
    input.name='renameprepare';

    input.onkeydown = function(e) {
        e = e || window.event;
        if (e.keyCode == 13) {
            rename(this.alt, this.value);
        }
    }

    input.onblur = function() {
        rename(this.alt, this.value);
    }

    objeto.removeChild(objeto.firstChild);
    objeto.appendChild(input);

    input.focus();
    input.select();
}

function rename(oldname, newname) {
    var url = document.getElementById('navurl').value;
    var ajax = new XMLHttpRequest();
    ajax.open('POST','/file-manager.php',true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.responseXML) {
                montapasta(this.responseXML);
            } else {
                mostramensagem('O retorno do servidor é inválido');
            }
        }
    }
    ajax.send('url='+url+'&opt=3&oldname='+oldname+'&newname='+newname);
}

window.onload = function() {
    var navurl = document.getElementById('navurl');
    ir((navurl.value ? navurl.value : '/'),1);
    navurl.onkeydown = function(e) {
        e = e || window.event;
        if (e.keyCode == '13') {
            ir(this.value,1);
            return false;
        }
    }
    $('#pasta').selectable({ delay: 20 });
    permissao();
}

function permissao(file) {
    var url = document.getElementById('navurl').value;
    var ajax = new XMLHttpRequest();
    ajax.open('POST','/file-manager.php',true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    if (file) ajax.file = file;

    ajax.onreadystatechange = function() {
        if (this.readyState == 4) {
            var resposta = new Array();
            resposta = this.responseText.split(':-:');

            var permissao = resposta[0];
            var donodoarquivo = resposta[1];

            var imgpermissao = document.getElementById('permissao');
            if (donodoarquivo == '1') {
                imgpermissao.src = '/admin/components/file-manager/img/permissoes/' + permissao + '.jpg';
                imgpermissao.title = 'Permissão da pasta: ' + permissao;
            } else {
                imgpermissao.src = '/admin/components/file-manager/img/permissoes/' + permissao + '_dis.jpg';
                imgpermissao.title = 'Permissão da pasta: ' + permissao + ' (Não é possível alterar as permissões)';
            }
            imgpermissao.response = permissao;
            imgpermissao.donodoarquivo = donodoarquivo

            if (this.file) imgpermissao.file = this.file

            imgpermissao.onmouseover = function() {
                if (this.donodoarquivo == '1') {
                    this.src = '/admin/components/file-manager/img/permissoes/' + this.response + '_hover.jpg';
                    this.style.cursor = 'pointer';
                }
            }

            imgpermissao.onmouseout = function() {
                if (this.donodoarquivo == '1') {
                    this.src = '/admin/components/file-manager/img/permissoes/' + this.response + '.jpg';
                    this.style.cursor = 'default';
                }
            }

            imgpermissao.onclick = function() {
                if (this.donodoarquivo == '1') {
                    if (this.file) {
                        ShowPermissionWindow(this, this.response, this.file);
                    } else {
                        ShowPermissionWindow(this, this.response);
                    }
                }
            }
        }
    }
    if (file) {
        ajax.send('url='+url+'&opt=4&file='+file);
    } else {
        ajax.send('url='+url+'&opt=4');
    }
}

function ShowPermissionWindow(img, prm, file) {
    var divwindow = document.getElementById('permission_window');
    if (divwindow) document.body.removeChild(divwindow);

    divwindow = document.createElement('div');
    divwindow.id = 'permission_window';
    document.body.appendChild(divwindow);

    divwindow.style.left = (img.offsetLeft - 224 + img.offsetWidth) + 'px';
    divwindow.style.top = (img.offsetTop + img.offsetHeight + 5) + 'px';

    // Título.
    var h1 = document.createElement('h1');
    h1.appendChild(document.createTextNode('Permissões da pasta'));
    divwindow.appendChild(h1);

    if (file) {
        divwindow.appendChild(ShowPermissionWindowForm(prm, file));
    } else {
        divwindow.appendChild(ShowPermissionWindowForm(prm, file));
    }
}

function ShowPermissionWindowForm(prm, file) {
    var digits = prm.split('');

    // Permissões.
    var ownerpbin = str_pad(decbin(digits[0]), 3, '0', 'STR_PAD_LEFT');
    var grouppbin = str_pad(decbin(digits[1]), 3, '0', 'STR_PAD_LEFT');
    var otherspbin = str_pad(decbin(digits[2]), 3, '0', 'STR_PAD_LEFT');

    var form = document.createElement('form');

    form.appendChild(checkfield('Permissões do proprietário', ownerpbin));
    form.appendChild(checkfield('Permissões do grupo', grouppbin));
    form.appendChild(checkfield('Permissões públicas', otherspbin));

    var btn1 = document.createElement('input');
    btn1.type = 'button';
    btn1.value = 'OK';

    if (file) btn1.file = file;

    btn1.onclick = function() {
        var form = this.parentNode;
        var fields = form.getElementsByTagName('fieldset');
        var perm = new Array();
        for (var i=0; i < fields.length; i++) {
            var ler = fields[i].childNodes[1].firstChild.checked ? 1 : 0;
            var gravar = fields[i].childNodes[2].firstChild.checked ? 1 : 0;
            var executar = fields[i].childNodes[3].firstChild.checked ? 1 : 0;
            perm[perm.length] = bindec(ler + '' + gravar + '' + executar);
        }
        var url = document.getElementById('navurl').value;
        var ajax = new XMLHttpRequest();
        ajax.open('POST','/file-manager.php',true);
        ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        if (this.file) ajax.file = this.file;
        ajax.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.file) {
                    permissao(this.file);
                } else {
                    permissao();
                }
                
                document.body.removeChild(document.getElementById('permission_window'));
                
                if (this.responseXML) {
                    montapasta(this.responseXML);
                } else {
                    mostramensagem('O retorno do servidor é inválido');
                }
            }
        }
        var newperm = perm.join('');
        if (this.file) {
            ajax.send('url='+url+'&opt=5&prm='+newperm+'&file='+this.file);
        } else {
            ajax.send('url='+url+'&opt=5&prm='+newperm);
        }
    }
    form.appendChild(btn1);

    var btn2 = document.createElement('input');
    btn2.type = 'button';
    btn2.value = 'Cancelar';
    btn2.onclick = function() {
        document.body.removeChild(this.parentNode.parentNode);
    }
    form.appendChild(btn2);

    return form;
}

function checkfield(legendtext, prm) {
    var digits = prm.split('');
    var fieldset = document.createElement('fieldset');
    var legend = document.createElement('legend');
    legend.appendChild(document.createTextNode(legendtext));
    fieldset.appendChild(legend);
    var labels = new Array('Ler', 'Gravar', 'Executar');
    for (var i=0; i < digits.length; i++) {
        var input = document.createElement('input');
        input.type = 'checkbox';
        input.checked = digits[i] == 1 ? true : false;
        var label = document.createElement('label');
        label.appendChild(input);
        label.appendChild(document.createTextNode(labels[i]));
        fieldset.appendChild(label);
    }
    return fieldset;
}

function validaUpload(form) {
    var input = form['arquivo[]'];
    for (var i=0; i < input.files.length; i++) {
        if (input.files[i].name.search(/^[a-zA-Z0-9._-]+$/) < 0) {
            mostramensagem('Não insira arquivos com caracteres latinos ou espaços');
            return false;
        }
    }
    return true;
}