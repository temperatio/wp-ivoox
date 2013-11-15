(function() {
    tinymce.create('tinymce.plugins.ivoox', {
        init : function(ed, url) {
            ed.addButton('ivoox', {
                title : 'Add an ivoox audio',
                image : url+'/img/ivoox-icon.png',
                onclick : function() {
                    // tb_show("", "../modal/params.php?");
                    // tinymce.DOM.setStyle(["TB_overlay", "TB_window", "TB_load"], "z-index", "999999")
                    //ed.selection.setContent('[ivoox]' + ed.selection.getContent() + '[/ivoox]');
                    // triggers the thickbox
                    var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                    W = W - 80;
                    H = H - 84;
                    // tb_show( 'ivoox Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=wpivoox-form' );
                    tb_show( 'ivoox Shortcode', '#TB_inline?inlineId=wpivoox-form' );
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('ivoox', tinymce.plugins.ivoox);

    // executes this when the DOM is ready
    jQuery(function(){
        // creates a form to be displayed everytime the button is clicked
        // you should achieve this using AJAX instead of direct html code like this
        var form = jQuery('<div id="wpivoox-form"><table id="wpivoox-table" class="form-table">\
            <tr>\
                <th><label for="wpivoox-type">Player type</label></th>\
                <td><select name="type" id="wpivoox-type">\
                    <option value="normal">HTML5 player</option>\
                    <option value="mini">Mini HTML5 player</option>\
                    <option value="flash">Flash player</option>\
                </select><br />\
                <small>specify the desired player.</small></td>\
            </tr>\
            <tr>\
                <th><label for="wpivoox-link">Link</label></th>\
                <td><input type="text" name="link" id="wpivoox-link" value="" /><br />\
                    <small>you can set it to "file" so each image will link to the image file, otherwise leave blank.</small></td>\
            </tr>\
        </table>\
        <p class="submit">\
            <input type="button" id="wpivoox-submit" class="button-primary" value="Insert Player" name="submit" />\
        </p>\
        </div>');

        var table = form.find('table');
        form.appendTo('body').hide();

        // handles the click event of the submit button
        form.find('#wpivoox-submit').click(function(){
            // defines the options and their default values
            // again, this is not the most elegant way to do this
            // but well, this gets the job done nonetheless
            var options = {
                'type'       : 'normal',
                'link'       : ''
                };
            var shortcode = '[ivoox';

            var type = table.find('#wpivoox-type').val();
            // attaches the attribute to the shortcode only if it's different from the default value
            if ( type !== options['type'] )
                shortcode += ' type="' + type + '"';

            shortcode += ']';

            var link = table.find('#wpivoox-link').val();
            if(link === ''){
                alert('Must provide a link');
            } else {
                shortcode += link + '[/ivoox]'
                // inserts the shortcode into the active editor
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                // closes Thickbox
                tb_remove();
            }

        });
    });
})();