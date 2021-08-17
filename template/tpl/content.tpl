    {include "header.tpl"}

    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
     <!-- HEADER -->
      <header>
         <div class="jumbotron">
           <div class="container">
              <div class="row flex">
                    <div class="col-xs-12 col-sm-7">
                            <h1>Парсер-агрегатор прайс-листа</h1>
                            <p>Решение, которое позволит периодически распарсивать некий прайс-лист, в котором есть наименования товаров, и их цена.</p>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                    <form action="" id="price-list-form" role="form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group input-group col-xs-12" id="drop-area">
                                <span class="input-group-addon"><span class="fas fa-file-alt"></span></span>
                                <input type="file" name="pricelist[]" accept="csv" class="form-control input-sm" value="" id="pricelist" required aria-required="true">
                            </div>
                            <div class="form-group col-xs-12">
                                <center><button type="submit" class="btn btn-success submit">Загрузить</button></center>
                            </div>
                        </div>
                    </form>
                    </div>
              </div>
            </div>
         </div>
      </header>
      <!-- HEADER END -->

       <!-- MAIN CONTENT -->
       <section class="main">
            <div class="container content {if !$Products}hide{/if}">
                  {include "panel.tpl"}
                  {include "table.tpl"}
            </div>
       </section>
      <!-- MAIN CONTENT END -->

      <!-- FOOTER BLOCK -->
      <footer>
           <div class="container">
             
            </div>
      </footer>
      <!-- FOOTER BLOCK END -->

      {include "footer.tpl"}