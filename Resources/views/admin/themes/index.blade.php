@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('workshop::themes.title') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('user::users.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('workshop::modules.breadcrumb.themes') }}</li>
</ol>
@stop

@section('styles')
    {!! Theme::style('css/vendor/iCheck/flat/blue.css') !!}
    <style>
        .jsUpdateModule {
            transition: all .5s ease-in-out;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('workshop::modules.table.name') }}</th>
                            <th width="15%">{{ trans('workshop::modules.table.version') }}</th>
                            <th width="15%">{{ trans('workshop::modules.table.enabled') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($themes)): ?>
                            <?php foreach($themes as $theme): ?>
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            {{ $theme->getName() }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            {{ $theme->version }}
                                        </a>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('workshop::modules.table.name') }}</th>
                            <th>{{ trans('workshop::modules.table.version') }}</th>
                            <th>{{ trans('workshop::modules.table.enabled') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <?php $locale = locale(); ?>
    <script>
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "columns": [
                    null,
                    null,
                    null,
                ]
            });
        });
    </script>
<script>
$( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    $('.jsUpdateModule').on('click', function(e) {
        $(this).data('loading-text', '<i class="fa fa-spinner fa-spin"></i> Loading ...');
        var $btn = $(this).button('loading');
        var token = '<?= csrf_token() ?>';
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.workshop.modules.update') ?>',
            data: {module: $btn.data('module'), _token: token},
            success: function(data) {
                console.log(data);
                if (data.updated) {
                    $btn.button('reset');
                    $btn.removeClass('btn-primary');
                    $btn.addClass('btn-success');
                    $btn.html('<i class="fa fa-check"></i> Module updated!')
                    setTimeout(function() {
                        $btn.removeClass('btn-success');
                        $btn.addClass('btn-primary');
                        $btn.html('Update')
                    }, 2000);
                }
            }
        });
    });
});
</script>
@stop
