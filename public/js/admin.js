// Устанавливаем заголовок для все Ajax запросов
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    // Применяем плагин tablesorter к таблице элементов
    if ($('#table_items').length) {

        $('#table_items').DataTable({
            "language": {
                "url": "/js/DataTable.Russian.json"
            }
        });

    }

    // Применяем плагин jQuery UI Sortable к таблице
    var $sortableTable = $('tbody.sortable');
    if ($sortableTable.length > 0) {
        $sortableTable.sortable({
            handle: '.sortable-handle',
            axis: 'y',
            update: function(a, b){

                var entityName = $(this).data('entityName');
                var $sorted = b.item;

                var $previous = $sorted.prev();
                var $next = $sorted.next();

                if ($previous.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentId'),
                        type: 'moveAfter',
                        entityName: entityName,
                        id: $sorted.data('itemId'),
                        positionEntityId: $previous.data('itemId')
                    });
                } else if ($next.length > 0) {
                    changePosition({
                        parentId: $sorted.data('parentId'),
                        type: 'moveBefore',
                        entityName: entityName,
                        id: $sorted.data('itemId'),
                        positionEntityId: $next.data('itemId')
                    });
                } else {
                    console.error('Something wrong!');
                }
            },
            cursor: "move"
        });
    }

    // Применять плагин datetime к полям типа дата
    if ($('.input-date').length) {

        $.datetimepicker.setLocale('ru');
        $('.input-date input').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            dayOfWeekStart: 1
        });

    }

    // Применять плагин datetime к полям типа дата
    if ($('.input-datetime').length) {

        $.datetimepicker.setLocale('ru');
        $('.input-datetime input').datetimepicker({
            format: 'Y-m-d H:i:s',
            dayOfWeekStart: 1
        });

    }

    // Применять плагин flora editor к html полям
    if ($('.input-html').length) {

        $('.input-html textarea').each(function(){
            CKEDITOR.replace( this );
        });

    }

});

/**
 * Подтверждения удаления элемента
 *
 * @param element
 * @param id
 * @param url
 */
function confirmDelete(element, id, url)
{
    sweetAlert({
        title: 'Удаление',
        text: 'Вы действительно хотите удалить запись #' + id + '?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: "Отмена",
        confirmButtonColor: '#D32F2F',
        confirmButtonText: 'Да, удалить!',
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, function(){
        if (!url) {
            url = window.location.href + '/' + id;
        }
        $.post(url, { '_method': 'DELETE' }, function(data){
            sweetAlert.close();
            var row = $(element).closest('table tr');
            if (row.length) {
                row.remove();
                $("#table_items").trigger("update");
            }
        })
        .fail(function(){
            sweetAlert("", "Ошибка при запросе к серсеру", 'error');
        })
        .always(function(){

        });
    });
}

/**
 * Сортировка таблицы
 *
 * @param type string 'insertAfter' or 'insertBefore'
 * @param entityName
 * @param id
 * @param positionId
 */
function changePosition(requestData)
{
    $.ajax({
        'url': '/admin/sort',
        'type': 'POST',
        'data': requestData,
        'success': function(data) {
            if (data.success) {
                //console.log('Saved!');
            } else {
                console.error(data.errors);
            }
        },
        'error': function(){
            console.error('Something wrong!');
        }
    });
};

/**
 * Удаление картинки
 *
 * @param element HTML Элемент (Кнопка или ссылка удаления)
 */
function deleteImage(element)
{
    var $preloader = $(element).next('.preloader');

    $(element).hide();

    if ($preloader.length){
        $preloader.show();
    }

    var data = {
        '_method':     'DELETE',
        'model_class': $(element).data('modelClass'),
        'model_id':    $(element).data('modelId')
    };
    $.post($(element).data('requestUrl'), data, function(data){
        $(element).parent().remove();
    }, 'json')
    .fail(function(){
        sweetAlert("", "Ошибка при запросе к серсеру", 'error');
        $(element).show();
    })
    .always(function(){
        if ($preloader.length){
            $preloader.hide();
        }
    });
}