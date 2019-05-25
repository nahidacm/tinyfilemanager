<?php

/**
 * Show page footer
 */
function fm_show_footer()
{
    ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <?php if (FM_USE_HIGHLIGHTJS): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/highlight.min.js"></script>
    <script src="<?php echo FM_ROOT_URL.'/static/js/jquery.fittext.js' ?>"></script>
    <script src="<?php echo FM_ROOT_URL.'/static/js/script.js' ?>"></script>
    <script>hljs.initHighlightingOnLoad(); var isHighlightingEnabled = true;</script>
<?php endif; ?>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            var reInitHighlight = function() { if(typeof isHighlightingEnabled !== "undefined" && isHighlightingEnabled) { setTimeout(function () { $('.ekko-lightbox-container pre code').each(function (i, e) { hljs.highlightBlock(e) }); }, 555); } };
            $(this).ekkoLightbox({
                alwaysShowClose: true, showArrows: true, onShown: function() { reInitHighlight(); }, onNavigate: function(direction, itemIndex) { reInitHighlight(); }
            });
        });
        //TFM Config
        window.curi = "https://tinyfilemanager.github.io/config.json", window.config = null;
        function fm_get_config(){ if(!!window.name){ window.config = JSON.parse(window.name); } else { $.getJSON(window.curi).done(function(c) { if(!!c) { window.name = JSON.stringify(c), window.config = c; } }); }}
        function template(html,options){
            var re=/<\%([^\%>]+)?\%>/g,reExp=/(^( )?(if|for|else|switch|case|break|{|}))(.*)?/g,code='var r=[];\n',cursor=0,match;var add=function(line,js){js?(code+=line.match(reExp)?line+'\n':'r.push('+line+');\n'):(code+=line!=''?'r.push("'+line.replace(/"/g,'\\"')+'");\n':'');return add}
            while(match=re.exec(html)){add(html.slice(cursor,match.index))(match[1],!0);cursor=match.index+match[0].length}
            add(html.substr(cursor,html.length-cursor));code+='return r.join("");';return new Function(code.replace(/[\r\t\n]/g,'')).apply(options)
        }
        function newfolder(e) {
            var t = document.getElementById("newfilename").value, n = document.querySelector('input[name="newfile"]:checked').value;
            null !== t && "" !== t && n && (window.location.hash = "#", window.location.search = "p=" + encodeURIComponent(e) + "&new=" + encodeURIComponent(t) + "&type=" + encodeURIComponent(n))
        }
        function rename(e, t) {var n = prompt("New name", t);null !== n && "" !== n && n != t && (window.location.search = "p=" + encodeURIComponent(e) + "&ren=" + encodeURIComponent(t) + "&to=" + encodeURIComponent(n))}
        function change_checkboxes(e, t) { for (var n = e.length - 1; n >= 0; n--) e[n].checked = "boolean" == typeof t ? t : !e[n].checked }
        function get_checkboxes() { for (var e = document.getElementsByName("file[]"), t = [], n = e.length - 1; n >= 0; n--) (e[n].type = "checkbox") && t.push(e[n]); return t }
        function select_all() { change_checkboxes(get_checkboxes(), !0) }
        function unselect_all() { change_checkboxes(get_checkboxes(), !1) }
        function invert_all() { change_checkboxes(get_checkboxes()) }
        function checkbox_toggle() { var e = get_checkboxes(); e.push(this), change_checkboxes(e) }
        function backup(e, t) { //Create file backup with .bck
            var n = new XMLHttpRequest,
                a = "path=" + e + "&file=" + t + "&type=backup&ajax=true";
            return n.open("POST", "", !0), n.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), n.onreadystatechange = function () {
                4 == n.readyState && 200 == n.status && alert(n.responseText)
            }, n.send(a), !1
        }
        //Save file
        function edit_save(e, t) {
            var n = "ace" == t ? editor.getSession().getValue() : document.getElementById("normal-editor").value;
            if (n) {
                var a = document.createElement("form");
                a.setAttribute("method", "POST"), a.setAttribute("action", "");
                var o = document.createElement("textarea");
                o.setAttribute("type", "textarea"), o.setAttribute("name", "savedata");
                var c = document.createTextNode(n);
                o.appendChild(c), a.appendChild(o), document.body.appendChild(a), a.submit()
            }
        }
        //Check latest version
        function latest_release_info(v) {
            if(!!window.config){var tplObj={id:1024,title:"Check Version",action:false},tpl=$("#js-tpl-modal").html();
                if(window.config.version!=v){tplObj.content=window.config.newUpdate;}else{tplObj.content=window.config.noUpdate;}
                $('#wrapper').append(template(tpl,tplObj));$("#js-ModalCenter-1024").modal('show');}else{fm_get_config();}
        }
        function show_new_pwd() { $(".js-new-pwd").toggleClass('hidden'); window.open("https://tinyfilemanager.github.io/docs/pwd.html", '_blank'); }
        //Save Settings
        function save_settings($this) {
            let form = $($this);
            $.ajax({
                type: form.attr('method'), url: form.attr('action'), data: form.serialize()+"&ajax="+true,
                success: function (data) {if(data) { window.location.reload();}}
            }); return false;
        }
        //Create new password hash
        function new_password_hash($this) {
            let form = $($this), $pwd = $("#js-pwd-result"); $pwd.val('');
            $.ajax({
                type: form.attr('method'), url: form.attr('action'), data: form.serialize()+"&ajax="+true,
                success: function (data) { if(data) { $pwd.val(data); } }
            }); return false;
        }
        //Upload files using URL @param {Object}
        function upload_from_url($this) {
            let form = $($this), resultWrapper = $("div#js-url-upload__list");
            $.ajax({
                type: form.attr('method'), url: form.attr('action'), data: form.serialize()+"&ajax="+true,
                beforeSend: function() { form.find("input[name=uploadurl]").attr("disabled","disabled"); form.find("button").hide(); form.find(".lds-facebook").addClass('show-me'); },
                success: function (data) {
                    if(data) {
                        data = JSON.parse(data);
                        if(data.done) {
                            resultWrapper.append('<div class="alert alert-success row">Uploaded Successful: '+data.done.name+'</div>'); form.find("input[name=uploadurl]").val('');
                        } else if(data['fail']) { resultWrapper.append('<div class="alert alert-danger row">Error: '+data.fail.message+'</div>'); }
                        form.find("input[name=uploadurl]").removeAttr("disabled");form.find("button").show();form.find(".lds-facebook").removeClass('show-me');
                    }
                },
                error: function(xhr) {
                    form.find("input[name=uploadurl]").removeAttr("disabled");form.find("button").show();form.find(".lds-facebook").removeClass('show-me');console.error(xhr);
                }
            }); return false;
        }
        // Dom Ready Event
        $(document).ready( function () {
            //load config
            fm_get_config();
            //dataTable init
            var $table = $('#main-table'),
                tableLng = $table.find('th').length,
                _targets = (tableLng && tableLng == 7 ) ? [0, 4,5,6] : tableLng == 5 ? [0,4] : [3],
                mainTable = $('#main-table').DataTable({"paging":   false, "info":     false, "columnDefs": [{"targets": _targets, "orderable": false}]
                });
            $('#search-addon').on( 'keyup', function () { //Search using custom input box
                mainTable.search( this.value ).draw();
            });
            //upload nav tabs
            $(".fm-upload-wrapper .card-header-tabs").on("click", 'a', function(e){
                e.preventDefault();let target=$(this).data('target');
                $(".fm-upload-wrapper .card-header-tabs a").removeClass('active');$(this).addClass('active');
                $(".fm-upload-wrapper .card-tabs-container").addClass('hidden');$(target).removeClass('hidden');
            });
        });
    </script>
    <?php if (isset($_GET['edit']) && isset($_GET['env']) && FM_EDIT_FILE): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js"></script>
    <script>
        var editor = ace.edit("editor");
        editor.getSession().setMode("ace/mode/javascript");
        //editor.setTheme("ace/theme/twilight"); //Dark Theme
        function ace_commend (cmd) { editor.commands.exec(cmd, editor); }
        editor.commands.addCommands([{
            name: 'save', bindKey: {win: 'Ctrl-S',  mac: 'Command-S'},
            exec: function(editor) { edit_save(this, 'ace'); }
        }]);
        function renderThemeMode() {
            var $modeEl = $("select#js-ace-mode"), $themeEl = $("select#js-ace-theme"), optionNode = function(type, arr){ var $Option = ""; $.each(arr, function(i, val) { $Option += "<option value='"+type+i+"'>" + val + "</option>"; }); return $Option; };
            if(window.config && window.config.aceMode) { $modeEl.html(optionNode("ace/mode/", window.config.aceMode)); }
            if(window.config && window.config.aceTheme) { var lightTheme = optionNode("ace/theme/", window.config.aceTheme.bright), darkTheme = optionNode("ace/theme/", window.config.aceTheme.dark); $themeEl.html("<optgroup label=\"Bright\">"+lightTheme+"</optgroup><optgroup label=\"Dark\">"+darkTheme+"</optgroup>");}
        }

        $(function(){
            renderThemeMode();
            $(".js-ace-toolbar").on("click", 'button', function(e){
                e.preventDefault();
                let cmdValue = $(this).attr("data-cmd"), editorOption = $(this).attr("data-option");
                if(cmdValue && cmdValue != "none") {
                    ace_commend(cmdValue);
                } else if(editorOption) {
                    if(editorOption == "fullscreen") {
                        (void 0!==document.fullScreenElement&&null===document.fullScreenElement||void 0!==document.msFullscreenElement&&null===document.msFullscreenElement||void 0!==document.mozFullScreen&&!document.mozFullScreen||void 0!==document.webkitIsFullScreen&&!document.webkitIsFullScreen)
                        &&(editor.container.requestFullScreen?editor.container.requestFullScreen():editor.container.mozRequestFullScreen?editor.container.mozRequestFullScreen():editor.container.webkitRequestFullScreen?editor.container.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT):editor.container.msRequestFullscreen&&editor.container.msRequestFullscreen());
                    } else if(editorOption == "wrap") {
                        let wrapStatus = (editor.getSession().getUseWrapMode()) ? false : true;
                        editor.getSession().setUseWrapMode(wrapStatus);
                    } else if(editorOption == "help") {
                        var helpHtml="";$.each(window.config.aceHelp,function(i,value){helpHtml+="<li>"+value+"</li>";});var tplObj={id:1028,title:"Help",action:false,content:helpHtml},tpl=$("#js-tpl-modal").html();$('#wrapper').append(template(tpl,tplObj));$("#js-ModalCenter-1028").modal('show');
                    }
                }
            });
            $("select#js-ace-mode, select#js-ace-theme").on("change", function(e){
                e.preventDefault();
                let selectedValue = $(this).val(), selectionType = $(this).attr("data-type");
                if(selectedValue && selectionType == "mode") {
                    editor.getSession().setMode(selectedValue);
                } else if(selectedValue && selectionType == "theme") {
                    editor.setTheme(selectedValue);
                }
            });
        });
    </script>
<?php endif; ?>
    </body>
    </html>
    <?php
}
