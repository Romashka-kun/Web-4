$(document).ready(function () {

    var lastClicked;
    var currentDir = $('.root > .content');
    currentDir.data('isLoaded', true);

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
                    // loadTree(currentDir);
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
            .on('click', 'div[title="Delete"]', function () {
                var delItems = [];
                tBody.children('.selected').each( function () {
                    delItems.push($(this).attr('rel'));
                });
                dialogConfirm(deleteFiles, delItems);
            });
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

    function deleteFiles(pathToDel) {
        $.ajax({
            method: 'POST',
            url: 'buttonFunc.php',
            data: {
                'deleteFiles': pathToDel
            },
            success: function () {
                loadDir(currentDir);
                // loadTree(currentDir);
            }
        });
    }

    function dialogConfirm(funcToExecute, pathToFile) {

        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Delete all items": function() {
                    funcToExecute(pathToFile);
                    $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

});