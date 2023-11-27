<?php
$this->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"');

?>
<div class="modal fade" id="visitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="height: 100%;" role="document">
        <div class="modal-content" style="height: 100%;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body" style="height: 100%;">
                <iframe src="https://crm.ortodom-spb.ru/record" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 999;"></iframe>
            </div>
        </div>
    </div>
</div>
<style>
    .error {
        display: none;
        margin-top: 10px;
        color: #5cb85c;
    }
    /*.modal-open {
        position: relative;
    }*/
    .datepicker {
        z-index: 1200;
    }
    .modal-dialog {
        width: 100%;
    }

    #visitModal button.close {
        position: relative;
        right: 30px;
        top: 30px;
        z-index: 2000;
    }

    .fade.show {
        opacity: 1;
    }
    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        display: none;
        overflow: hidden;
        -webkit-overflow-scrolling: touch;
        outline: 0;
    }
    .fade {
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }

    .modal-open {
        overflow: hidden;
    }
    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }


    /*.modal.in .modal-dialog {
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        -o-transform: translate(0,0);
        transform: translate(0,0);
    }*/
    .modal-dialog {
        width: 100%;
        margin: 10px;
    }
    @media (min-width: 768px) {
        .modal-dialog {
            margin: 30px auto;
        }
    }

    @media (min-width: 768px) {
        .modal-content {
            -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
        }
        .modal-content {
            position: relative;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #999;
            border: 1px solid rgba(0,0,0,.2);
            border-radius: 6px;
            -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
            box-shadow: 0 3px 9px rgba(0,0,0,.5);
            outline: 0;
        }
    }


    button.close {
        padding: 0;
        cursor: pointer;
        background: 0 0;
        border: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .close {
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
    }

    .modal-body {
        position: relative;
        padding: 15px;
    }
    .modal-backdrop.show {
        opacity: .5;
    }
    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #000;
    }
    .fade {
        transition: opacity .15s linear;
    }

</style>


