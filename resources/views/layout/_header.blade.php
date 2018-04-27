<nav class="navbar navbar-collapse btn-info">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="glyphicon glyphicon-menu-hamburger"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand glyphicon glyphicon-grain" href="#">eleb</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="">饿了吧 <span class="sr-only">(current)</span></a></li>
                {{--<li class="active"><a href="">列表 <span class="sr-only">(current)</span></a></li>--}}
                {{--<li><a href="">添加</a></li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">管理<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li><a href="{{route('businessList.index')}}">店铺列表</a></li>--}}
                        {{--<li><a href="{{route('businessList.create')}}">注册店铺</a></li>--}}
                        {{--<li role="separator" class="divider"></li>--}}
                        {{--<li><a href="{{route('category.index')}}">店铺分类列表</a></li>--}}
                        {{--<li><a href="{{route('category.create')}}">添加店铺分类</a></li>--}}
                        {{--<li role="separator" class="divider"></li>--}}
                        {{--<li><a href="{{route('foodCategory.index')}}">食品分类列表</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            </ul>
            {{--<form class="navbar-form navbar-left">--}}
                {{--<div class="form-group">--}}
                    {{--<input type="text" class="form-control" placeholder="Search">--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-default">Submit</button>--}}
            {{--</form>--}}
            <ul class="nav navbar-nav navbar-right">
                <li><a href="" style="color: #3471ef">注册</a></li>
                <li>&emsp;</li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target=".bs-example-modal-sm">注册管理员</button>
                        </li>
                        <li><a href="" >管理员列表</a></li>
                        <li role="separator" class="divider"></li>
                        {{--{{route('user.edit',['user'=>$user])}}修改当前管理员信息--}}
                        <li><a href="">...</a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <form action="" method="post">
                                <input type="submit" value="退出登录" class="btn btn-link">
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

{{--注册管理员模态框--}}



<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">注册管理员</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="shop_name">管理员名称</label>
                        <input type="text" name="name" class="form-control" id="shop_name" placeholder="请输入管理员名称">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <label >确认密码</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="确认密码">
                    </div>
                    <button type="submit" class="btn btn-default btn-block">注册管理员</button>
                    {{csrf_field()}}
                </form>
            </div>
        </div>
    </div>
</div>