$(document).ready(function () {
    /* Handle chart */
    if ($("#chart").length) {
        var options = {
            series: [
                {
                    name: "",
                    data: CHARTS["series"],
                },
            ],
            chart: {
                height: 450,
                type: "line",
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "straight",
            },
            title: {
                text: "",
                align: "left",
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"],
                    opacity: 0.5,
                },
            },
            labels: CHARTS["labels"],
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    }
    /*Handle generate slug*/
    function removeSpecialCharacter(str) {
        str = str.toLowerCase();
        str = str.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
        str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
        str = str.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
        str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
        str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
        str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
        str = str.replace(/đ/gi, "d");
        str = str.replace(
            /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
            ""
        );
        str = str.replace(/ /gi, "-");
        str = str.replace(/\-\-\-\-\-/gi, "-");
        str = str.replace(/\-\-\-\-/gi, "-");
        str = str.replace(/\-\-\-/gi, "-");
        str = str.replace(/\-\-/gi, "-");
        return str;
    }

    function generateSlug(value) {
        return removeSpecialCharacter(value).replace(/\s/g, "-");
    }

    if ($(".for-seo")) {
        $(".for-seo").keyup(function (event) {
            const { value } = event.target;
            if (value) {
                $(".slug-seo").attr("value", generateSlug(value));
                $(".slug-seo").attr("readonly", true);
            } else {
                $(".slug-seo").attr("value", "");
                $(".slug-seo").attr("readonly", false);
            }
        });
    }

    /*Build SEO Automation*/
    function htmlToText(value) {
        const text = value
            .replace(/<style([\s\S]*?)<\/style>/gi, " ")
            .replace(/<script([\s\S]*?)<\/script>/gi, " ")
            .replace(/(<(?:.|\n)*?>)/gm, " ")
            .replace(/\s+/gm, " ");
        return text;
    }

    if ($(".build-seo")) {
        $(".build-seo").click(function () {
            const title = $(this)
                .parents(".content")
                .find(".card-body.card-article #title")
                .val();

            const titleSeo = $(this)
                .parents(".card-header")
                .next()
                .children()
                .find("#title_seo");

            const keywordSeo = $(this)
                .parents(".card-header")
                .next()
                .children()
                .find("#keywords_seo");

            if (title) {
                titleSeo.val(title);
                keywordSeo.val(title);
            } else {
                titleSeo.val("");
                keywordSeo.val("");
            }
        });
    }

    /*Handle format price*/
    if ($(".format-price").length) {
        $(".format-price").priceFormat({
            limit: 13,
            prefix: "",
            centsLimit: 0,
        });
    }

    /* Rounde number */
    function roundNumber(roundNumber, roundLength) {
        return (
            Math.round(roundNumber * Math.pow(10, roundLength)) /
            Math.pow(10, roundLength)
        );
    }

    /*Hanlde generate discount*/
    if ($(".regular_price").length && $(".sale_price").length) {
        $(".sale_price").keyup(function () {
            $(".regular_price").prop("disabled", false);
            let price3 = $(this).val();
            let price2 = price3.replace(",", "");
            let price1 = price2.replace(",", "");
            let price = price1.replace(",", "");
            $(this).attr("value", price);
        });
        $(".sale_price").blur(function () {
            let key = $(".sale_price").attr("value");
            if (key > 0) {
                $(".regular_price").prop("disabled", false);
            } else {
                $(".regular_price").val(0);
                $(".regular_price").prop("disabled", true);
            }
        });
        $(".regular_price, .sale_price").keyup(function () {
            let regularPriceValue = $(".regular_price").val();
            let salePriceValue = $(".sale_price").length
                ? $(".sale_price").val()
                : 0;
            let discountNumber = 0;

            if (
                regularPriceValue == "" ||
                regularPriceValue == "0" ||
                salePriceValue == "" ||
                salePriceValue == "0"
            ) {
                discountNumber = 0;
            } else {
                regularPriceValue = regularPriceValue.replace(/,/g, "");
                salePriceValue = salePriceValue
                    ? salePriceValue.replace(/,/g, "")
                    : 0;
                regularPriceValue = parseInt(regularPriceValue);
                salePriceValue = parseInt(salePriceValue);

                if (salePriceValue < regularPriceValue) {
                    discountNumber =
                        100 - (salePriceValue * 100) / regularPriceValue;
                    discountNumber = roundNumber(discountNumber, 0);
                } else {
                    if ($(".discount").length) {
                        discountNumber = 0;
                    }
                }
            }
            if ($(".discount").length) {
                $(".discount").val(discountNumber);
            }
        });
    }

    /* Reader image */
    function readImage(inputFile, elementPhoto) {
        if (inputFile[0].files[0]) {
            if (
                inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif|webp)$/i)
            ) {
                let size = parseInt(inputFile[0].files[0].size) / 1024;

                if (size <= 4096) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $(elementPhoto).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(inputFile[0].files[0]);
                } else {
                    alert("Dung lượng ảnh lớn hơn dung lượng cho phép 4096kb");
                    return false;
                }
            } else {
                $(elementPhoto).attr("src", "");
                alert("Định dạng hình ảnh không hợp lệ");
                return false;
            }
        } else {
            $(elementPhoto).attr("src", `${BASE_URL}public/images/noimage.png`);
            return false;
        }
    }
    /*Photo Zone*/
    function photoZone(eDrag, iDrag, eLoad) {
        if ($(eDrag).length) {
            /* Drag over */
            $(eDrag).on("dragover", function () {
                $(this).addClass("drag-over");
                return false;
            });

            /* Drag leave */
            $(eDrag).on("dragleave", function () {
                $(this).removeClass("drag-over");
                return false;
            });

            /* Drop */
            $(eDrag).on("drop", function (e) {
                e.preventDefault();
                $(this).removeClass("drag-over");
                var lengthZone = e.originalEvent.dataTransfer.files.length;
                if (lengthZone == 1) {
                    $(iDrag).prop("files", e.originalEvent.dataTransfer.files);
                    readImage($(iDrag), eLoad);
                } else if (lengthZone > 1) {
                    alert("Bạn chỉ được chọn 1 hình ảnh để upload");
                    return false;
                } else {
                    alert("Dữ liệu không hợp lệ");
                    return false;
                }
            });

            /* File zone */
            $(iDrag).change(function () {
                readImage($(this), eLoad);
            });
        }
    }
    /*Preview photo1*/
    if ($("#photo-zone1").length) {
        photoZone("#photo-zone1", "#file-zone1", "#photoUpload-preview1 img");
    }
    /*Preview photo2*/
    if ($("#photo-zone2").length) {
        photoZone("#photo-zone2", "#file-zone2", "#photoUpload-preview2 img");
    }
    /*Preview photo3*/
    if ($("#photo-zone3").length) {
        photoZone("#photo-zone3", "#file-zone3", "#photoUpload-preview3 img");
    }
    /*Preview photo4*/
    if ($("#photo-zone4").length) {
        photoZone("#photo-zone4", "#file-zone4", "#photoUpload-preview4 img");
    }

    /*Handle check all && checkitem*/
    if ($(".checkall") && $(".checkitem")) {
        $(".checkall").change(function () {
            $(this).prop("checked") === true
                ? $(".checkitem").prop("checked", true)
                : $(".checkitem").prop("checked", false);
        });
        $(".checkitem").change(function () {
            const itemIsChecked = $('input[name="checkitem[]"]:checked');
            itemIsChecked.length &&
            $(".checkitem").length === itemIsChecked.length
                ? $(".checkall").prop("checked", true)
                : $(".checkall").prop("checked", false);
        });
    }

    /* Handle delete all row */
    if ($(".delete-all")) {
        $(".delete-all").click(function () {
            const url = $(this).data("url");
            const itemIsChecked = $('input[name="checkitem[]"]:checked');
            if (itemIsChecked) {
                if (itemIsChecked.length === 0) {
                    confirm("Bạn hãy chọn ít nhất 1 mục để xóa");
                    return false;
                } else {
                    $(".form-product-list").attr("action", url);
                    const message = confirm(
                        "Bạn có chắc muốn xóa mục này không ?"
                    );
                    if (message) $(".form-product-list").submit();
                    return false;
                }
            }
        });
    }

    /*Handle request delete all*/
    if ($(".delete-all-request")) {
        $(".delete-all-request").click(function () {
            const url = $(this).data("url");
            const itemIsChecked = $('input[name="checkitem[]"]:checked');
            if (itemIsChecked.length === 0) {
                confirm("Bạn hãy chọn ít nhất 1 mục để xóa");
                return false;
            } else {
                $(".form-newsletter-request").attr("action", url);
                const message = confirm("Bạn có chắc muốn xóa mục này không ?");
                if (message) {
                    $(".form-newsletter-request").submit();
                }
                return false;
            }
        });
    }

    /* Handle delete one row */
    if ($(".delete-row")) {
        $(".delete-row").click(function () {
            const message = confirm("Bạn có chắc muốn xóa mục này không ?");
            const url = $(this).data("url");
            $(".form_delete_row").attr("action", url);
            if (message) $(".form_delete_row").submit();
            return false;
        });
    }

    /* Handle update num */
    if ($(".update-num")) {
        $(".update-num").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "GET",
                data: {
                    id: $(this).data("id"),
                    value: $(this).val(),
                },
                dataType: "text",
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }
    /* Handle update num post */
    if ($(".update-num-post")) {
        $(".update-num-post").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "GET",
                data: {
                    id: $(this).data("id"),
                    type: $(this).data("type"),
                    value: parseInt($(this).val()),
                },
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }
    /* Handle update num newsletter*/
    if ($(".update-num-newsletter")) {
        $(".update-num-newsletter").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "POST",
                data: {
                    id: $(this).data("id"),
                    value: $(this).val(),
                    _token: $(this).data("token"),
                },
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle update num photo module */
    if ($(".update-num-photo")) {
        $(".update-num-photo").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "GET",
                data: {
                    id: $(this).data("id"),
                    value: $(this).val(),
                    type: $(this).data("type"),
                },
                dataType: "text",
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle update status */
    if ($(".update-status")) {
        $(".update-status").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "GET",
                data: {
                    id: $(this).data("id"),
                    value: $(this).attr("name"),
                },
                dataType: "text",
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle update status photo */
    if ($(".update-status-photo")) {
        $(".update-status-photo").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "GET",
                data: {
                    id: $(this).data("id"),
                    value: $(this).attr("name"),
                    type: $(this).data("type"),
                },
                dataType: "text",
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle build-schema */
    if ($(".build-schema")) {
        $(".build-schema").click(function () {
            $(".form-schema").submit();
            return false;
        });
    }

    /* Handle gallery dropzone image */
    Dropzone.options.dropzoneFrom = {
        autoProcessQueue: true,
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.webp",
        init: function () {
            this.on("complete", function () {
                if (
                    this.getQueuedFiles().length == 0 &&
                    this.getUploadingFiles().length == 0
                ) {
                    let _this = this;
                    _this.removeAllFiles();
                }
            });
        },
    };

    /* Handle click position watermark */
    if ($(".watermark-position label").length) {
        $(".watermark-position label").click(function () {
            const urlNoimage = $(this).data("url");
            const idInputRadio = $(this).find("input").attr("id");
            if ($(".upload-file-image img").length) {
                var img = $(".upload-file-image img").attr("src");

                if (img) {
                    $("#" + idInputRadio).prop("checked", true);
                    $(".watermark-position label img").attr("src", urlNoimage);
                    $(this).find("img").attr("src", img);
                    $(this).find("img").show();
                } else {
                    $("#" + idInputRadio).prop("checked", false);
                }
            }
            return false;
        });
    }

    /* Handle Update Title Gallery Image */
    if ($(".gallery-title")) {
        $(".gallery-title").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "POST",
                data: {
                    id: $(this).data("id"),
                    value: $(this).val(),
                    _token: $(this).data("token"),
                },
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle Update Number Gallery Image */
    if ($(".update-num-gallery")) {
        $(".update-num-gallery").change(function () {
            $.ajax({
                url: $(this).data("url"),
                method: "POST",
                data: {
                    id: $(this).data("id"),
                    value: $(this).val(),
                    _token: $(this).data("token"),
                },
                success: function (respone) {
                    return false;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    }

    /* Handle change filter category */
    if ($(".filter-category")) {
        $(".filter-category").change(function () {
            const child = $(this).data("child");
            const level = parseInt($(this).data("level"));
            const id = $(this).val();
            const url = $(this).data("url");
            if ($("#" + child).length) {
                $.ajax({
                    url: url,
                    data: {
                        id: id,
                        _token: $(this).data("token"),
                    },
                    method: "POST",
                    success: function (respone) {
                        var option = "<option value='0'>Chọn danh mục</option>";
                        if (level == 1) {
                            $("#id_parent2").html(option);
                            $("#id_parent3").html(option);
                            $("#id_parent4").html(option);
                        } else if (level == 2) {
                            $("#id_parent3").html(option);
                            $("#id_parent4").html(option);
                        } else if (level == 3) {
                            $("#id_parent4").html(option);
                        }
                        $("#" + child).html(respone);
                        return false;
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    },
                });
            }
        });
    }

    if ($(".select2").length) {
        $(".select2").select2();
    }

    /* Handle change filter rendering category */
    if ($(".filter-category-rendering")) {
        $(".filter-category-rendering").change(function () {
            const url = $(this).find(":selected").val();
            const level = parseInt($(this).data("level"));
            var option = "<option value='0'>Chọn danh mục</option>";
            if (level == 1) {
                $("#id_parent2").html(option);
                $("#id_parent3").html(option);
                $("#id_parent4").html(option);
            } else if (level == 2) {
                $("#id_parent1").html(option);
                $("#id_parent3").html(option);
                $("#id_parent4").html(option);
            } else if (level == 3) {
                $("#id_parent1").html(option);
                $("#id_parent3").html(option);
                $("#id_parent4").html(option);
            } else {
                $("#id_parent1").html(option);
                $("#id_parent2").html(option);
                $("#id_parent3").html(option);
            }
            window.location.href = url;
        });
    }

    if ($(".keyword-request")) {
        $(".keyword-request").keypress(function (e) {
            const url = $(this).data("url");
            if (e.which == 13 || e.keyCode == 13) {
                let data = $(this).serialize();
                if (url) {
                    const redirect = `${url}?${data}`;
                    window.location.href = redirect;
                }
                return false;
            }
        });
    }
    if ($(".btn-newsl-keyword")) {
        $(".btn-newsl-keyword").click(function (e) {
            const url = $(".keyword-request").data("url");
            let data = $(".keyword-request").serialize();
            if (data) {
                if (url) {
                    const redirect = `${url}?${data}`;
                    window.location.href = redirect;
                }
            }
            return false;
        });
    }

    if ($(".multiselect").length) {
        window.asd = $(".multiselect").SumoSelect({
            placeholder: "Chọn danh mục",
            selectAll: true,
            search: true,
            searchText: "Tìm kiếm",
            locale: ["OK", "Hủy", "Chọn hết"],
            captionFormat: "Đã chọn {0} mục",
            captionFormatAllSelected: "Đã chọn tất cả {0} mục",
        });
    }
    // if ($(".form_cke").length) {
    //     $(".form_cke").each(function () {
    //         var id = $(this).attr("id");
    //         CKEDITOR.replace(id, options);
    //     });
    // }
});
