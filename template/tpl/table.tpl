<div class="wrapper-table">
    <div class="alert alert-success {if !$avg}hidden{/if}" role="alert">
        <h4 class="alert-heading">Средняя цена за сутки!</h4>
        <p>Средняя цена выпарсенного товара за сутки, относительно текущего времени составляет - {$avg} руб.</p>
        <hr>
    </div>
    <table class="table table-striped {if $avg}hidden{/if}">
        <thead>
        <tr>
            <th>id</th>
            <th>Название товара</th>
            <th>Цена товара / <i class="fas fa-ruble-sign"></i></th>
        </tr>
        </thead>
        <tbody class="table-row">
            {include "table-row.tpl"}
        </tbody>
    </table>
</div>


