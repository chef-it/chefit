<!-- Production TODO: Remove -->
<div class="container">
    <div id="Debuging" class="col-md-12">
        <div class="block-flat">
            <div>
                <div class="header">
                    <hr>
                    <h3 class="text-center">Variable Dump</h3>
                </div>
                <div>
                    {{ dump(get_defined_vars()['__data']) }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Production -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>