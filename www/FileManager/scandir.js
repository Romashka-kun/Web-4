$(document).ready(function () {

    var lastClicked;
    var currentDir = $('.root > .content');

    var tBody = $('tbody');
    var tree = $('.tree');
    var toolbar = $('.toolbar');

    var DELAY = 500;
    var clicks = 0;
    var timer = null;

    $(function () {

        tree.on('click', '.content', function () {

            var dir = $(this);
            clicks++;

            if (clicks === 1) {
                timer = setTimeout(function () {
                    loadDir(dir);
                    clicks = 0;
                }, DELAY);

            } else {
                clearTimeout(timer);
                loadTree(dir);
                clicks = 0;
            }
        })

            .on('dblclick', '.content', function (e) {
                e.preventDefault();
            });

    });

    $(function () {

        tBody.on('click', '.table-item', function (evt) {
            var item = $(this);
            if (evt.ctrlKey) {
                item.toggleClass('selected');
            } else if (evt.shiftKey) {
                if (item.index() > lastClicked.index())
                    lastClicked.nextUntil(item).add(item).addClass('selected');
                else
                    lastClicked.prevUntil(item).add(item).addClass('selected');
            } else {
                item.siblings().removeClass('selected');
                item.addClass('selected');
            }
            lastClicked = item;
        })
            .on('dblclick', '.table-dir', function () {
                loadDir($(this));
            });

    });

    $(function () {

        toolbar.on('click', 'div[title="New folder"]', function () {
            var name = 'folder';
            $.ajax({
                method: 'POST',
                url: 'buttonFunc.php',
                data: {
                    'createFolder': name
                },
                success: function () {
                    loadDir(currentDir);
                    loadTree(currentDir);
                }
            });
        })
            .on('click', 'div[title="New file"]', function () {
                var name = 'newFile.txt';
                $.ajax({
                    method: 'POST',
                    url: 'buttonFunc.php',
                    data: {
                        'createFile': name
                    },
                    success: function () {
                        loadDir(currentDir)
                    }
                });
            })
    });

    function loadDir(dir) {

        var dirPath = dir.attr('rel');
        currentDir = dir;
        $.ajax({
            method: 'GET',
            url: 'ajax-table-content.php',
            data: 'dir=' + dirPath,
            success: function (data) {
                tBody.children().remove();
                tBody.append(data)
            }
        });
        console.log(currentDir.attr('rel'));
    }

    function loadTree(dir) {

        dir.siblings().toggle();

        if (!dir.data('isLoaded')) {
            dir.data('isLoaded', true);
            var dirPath = dir.attr('rel');

            $.ajax({
                method: 'GET',
                url: 'ajax-for-scandir.php',
                data: 'dir=' + dirPath,
                success: function (data) {
                    if (data.length > 27)
                        dir.after(data);
                }
            });
        }
    }

});