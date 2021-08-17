<div class="panel">
    <div class="row flex">
        <div class="item-form col-xs-12 col-sm-3">
            <button  class="btn btn-primary control" id="lastThree">За предыдущие 3 часа</button>
        </div>
        <div class="item-form col-xs-12 col-sm-3">
            <button  class="btn btn-primary control" id="middlePrice">Cредняя цена товара за сутки</button>
        </div>
        <div class="item-form col-xs-12 col-sm-6">
            <div class="row flex">
                <div class="form-group col-xs-12 col-sm-4">
                    <label for="start">С:</label>
                    <input type="date" id="start" class="control" name="trip-start" value="{$date | date : 'Y-m-d'}" min="{$date | date : 'Y-m-d'}">
                </div>
                <div class="form-group col-xs-12 col-sm-4">
                    <label for="start">По:</label>
                    <input type="date" id="end" name="trip-end" class="control" value="{$date | date : 'Y-m-d'}" min="{$date | date : 'Y-m-d'}">
                </div>
                <div class="form-group col-xs-12 col-sm-4">
                    <button  class="btn btn-primary control" id="periodPrice">Отправить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="item-form col-xs-12">
            <button  class="btn btn-warning" id="reset">Сбросить</button>
        </div>
    </div>
</div>
