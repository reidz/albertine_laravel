<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
        .navbar-container{
            width: 1000px;
        }
        .navbar{
            text-align: center;
            margin-bottom: 0;
        }
        .no-padding{
          padding-left:0;
          padding-right:0;
        }

        .gallery_product
        {
            margin-bottom: 30px;
            text-align: center;
        }

        .gallery_product img
        {
            border: 1px solid #50514F;
        }


    </style>
</head>
<body>
    <div id="header">
        <nav class="navbar navbar-default">
            <div class="container-fluid navbar-container">
                <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="#">ALBERTINE</a>
                    </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="margin-left: 200px;">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">HOME <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/category', 'admin/category/*') ? 'active' : '' }}"><a href="{{route('category.index')}}">COLLECTIONS <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/product', 'admin/product/*') ? 'active' : '' }}"><a href="{{route('product.index')}}">HOW TO ORDER</a></li>
                        <li class="{{ Request::is('admin/size', 'admin/size/*') ? 'active' : '' }}"><a href="{{route('size.index')}}">CONTACT</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">SIGN IN/SIGN UP | <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">Cart <span class="sr-only">(current)</span></a></li>
                        {{-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    @section('content')
    @show
    <div id="footer">
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container-fluid navbar-container">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">HOW TO ORDER <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/category', 'admin/category/*') ? 'active' : '' }}"><a href="{{route('category.index')}}">SIZE CHART <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/product', 'admin/product/*') ? 'active' : '' }}"><a href="{{route('product.index')}}">RETURN POLICY</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">WHATSAPP 0896 1598 0764 | <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">LINE @AlbertineWorld (use @) | <span class="sr-only">(current)</span></a></li>
                        <li class="{{ Request::is('admin/asset', 'admin/asset/*') ? 'active' : '' }}"><a href="{{route('asset.index')}}">EMAIL hello@albertineworld.com <span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</body>
</html>