$(document).ready(function(){
    //checkbox init
    $('.ui.checkbox').checkbox();

    //markdown and highlight init
    marked.setOptions({
        renderer: new marked.Renderer(),
        gfm: true,
        tables: true,
        breaks: true,
        pedantic: false,
        sanitize: true,
        smartLists: true,
        smartypants: false,
        highlight: function (code) {
            return hljs.highlightAuto(code).value;
        }
    });
    //markdown preview
    $('.textarea').on('input propertychange',function(){
        var html = marked($('.textarea').val());
        $('#preview').html(html);
    });

});