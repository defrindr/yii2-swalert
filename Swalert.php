<?php

namespace defrindr;

/**
 * This is just an example.
 */
class Swalert extends \yii\base\Widget
{
    public function run()
    {
        SwalertAsset::register($this->getView());

        $data_flash_success = \Yii::$app->session->getFlash('success');
        $data_flash_error = \Yii::$app->session->getFlash('error');


        $data = [];
        if (gettype($data_flash_success) == 'string') {
            $data[] = [
                "title" => "Berhasil !",
                "text" => $data_flash_success,
                "type" => "success",
            ];
        } else if (gettype($data_flash_success) == "array") {
            foreach ($data_flash_success as $item) {
                $data[] = [
                    "title" => "Berhasil !",
                    "text" => $item,
                    "type" => "success",
                ];
            }
        }

        if (gettype($data_flash_error) == 'string') {
            $data[] = [
                "title" => "Gagal !",
                "text" => $data_flash_error,
                "type" => "error",
            ];
        } else if (gettype($data_flash_error) == "array") {
            foreach ($data_flash_error as $item) {
                $data[] = [
                    "title" => "Gagal !",
                    "text" => $item,
                    "type" => "error",
                ];
            }
        }

        $data_json = json_encode($data);
        $js =<<<JS
yii.confirm = function(message, okCallback, cancelCallback) {
        // swal fires the callback when the user clicks on the confirm button
        Swal.fire({
            title: "Apakah anda yakin ?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                okCallback();
            }
        });
    };

    window.alert = function(message) {
        Swal.fire({
            title: "Notifikasi",
            text: message,
            icon: "info",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "OK",
            closeOnConfirm: false
        });
    };

    $(document).ready(function() {
        var modals = $data_json;
        if (modals == null) {
            modals = [];
        }

        Swal.queue(modals);
    });
JS;
        $this->getView()->registerJs($js);
    }
}
