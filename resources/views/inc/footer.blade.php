<footer class=" body-footer">
    <div class="container">
        <div class="row">
        <div class="col-md-4 column-footer">
            <span class="h3">Контакты</span>
            <p class="mt-2">
                <a href="tel:+380979560001" class=" btn btn-link">+380 (97) 956-00-01</a>
            </p>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 column-footer">
            <span class="h3 d-block pb-2">
                Меню
            </span>
            <!-- /.h5 -->
            <a href="{{route('sitemap.html')}}">
                Карта сайта
            </a>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 column-footer">
            <span class="h3">Форма для связи</span>
            <feedback-form></feedback-form>
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
    <div class="row py-3">
        <div class="col text-center">
            <span>Fast &copy; {{date('Y')}} год.</span>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->


</footer>
