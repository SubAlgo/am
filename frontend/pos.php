<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 left-panel">
            <!-- Start barcode input -->
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Barcode</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="barcode" aria-describedby="button-addon2" id="barcode" autocomplete="off" autofocus>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-addon2" id="search">ค้นหา
                                [Enter]</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 text-right text-muted" id="total-qty"></div>
            </div>
            <!-- End barcode input -->

            <table class="table table-bordered table-striped">
                <!-- Start Set Header -->
                <thead>
                    <tr class="text-center text-light bg-dark">
                        <th style="width: 5%">#</th>
                        <th style="width: 50%">สินค้า</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 10%">ราคาต่อชิ้น</th>
                        <th style="width: 15%">รวม</th>
                        <th style="width: 10%">ลบ</th>
                    </tr>
                </thead>
                <!-- End Set Header -->

                <tbody id="saleList"></tbody>
            </table>
        </div>


        <div class="col-md-4 right-panel">
            <div class="card">
                <div class="card-header">คำนวณเงิน</div>
                <div class="card-body">
                    <table class="cal-table">
                        <tbody>
                            <tr>
                                <td class="f-26">รับเงิน <br/>
                                <small id="receive-help" class="form-text text-muted f-14">[Spacebar]</small>
                            </td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" placeholder="" aria-label="receive" aria-describedby="basic-addon2" name="receive" id="receive">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">บาท</span>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td class="f-26">ราคารวม</td>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-lg" placeholder="" aria-label="sum" aria-describedby="basic-addon2" id="sum" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">บาท</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="f-26">เงินทอน</td>
                                <td>

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-lg" placeholder="" aria-label="change" aria-describedby="basic-addon2" id="change" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">บาท</span>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-muted">
                    <button type="button" class="btn btn-danger btn-block" id="clear">ล้างข้อมูล <br /> [F5]</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    let basket = [];

    function removeItem(id) {
        basket = basket.filter(b => b.id != id);
        calculate()
    }

    function changeQty(id, index, value) {
        if (value < 1) {
            removeItem(id)
            return
        }
        basket[index].qty = parseInt(value)
        calculate()
    }

    const calculate = () => {
        const sum = basket.reduce((result, product) => {
            return result + (product.price * product.qty)
        }, 0)
        $("#sum").val(sum)
        renderTable();
    }

    function renderTable() {
        const productList = []
        let totalQty = 0
        basket.map((p, index) => {
            const product = `<tr>
                    <td>${index + 1}</td>
                    <td>${p.name}</td>
                    <td><input class="text-center form-control" type="number" id="qty-${index}" value="${p.qty}" onchange="changeQty(${p.id}, ${index}, this.value)"></td>
                    <td class="text-right">${p.price}<span class="text-muted">.00</span></td>
                    <td class="text-right">${p.price * p.qty}<span class="text-muted">.00</span></td>
                    <td class="text-center pt-1 pb-1">
                        <button type="button" class="close" aria-label="Close" id="del-${index}" onclick="removeItem(${p.id})">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </td>
                </tr>`
            productList.push(product)
            totalQty += p.qty
        })
        document.getElementById("saleList").innerHTML = productList.join("")
        if (totalQty > 0) {
            document.getElementById("total-qty").innerHTML = `<span>รวมจำนวนสินค้า ${totalQty} ชิ้น </span>`
        }
    }

    $(document).ready(function() {
        $('#barcode').focus()

        // ----- Start function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----
        let searchHandle = () => {
            let barcode = $("#barcode").val()
            barcode = barcode.trim()

            // check char is not Thai charactor
            let firstCharOfBarcode = barcode.charCodeAt(0)
            var newBarcode = ""
            switch (firstCharOfBarcode) {
                case 3653:
                case 47:
                case 45:
                case 3616:
                case 3606:
                case 3640:
                case 3638:
                case 3588:
                case 3605:
                    let len = barcode.length
                    for (let i = 0; i < len; i++) {
                        switch (barcode.charAt(i)) {
                            case "ๅ":
                                newBarcode = newBarcode + "1"
                                break;
                            case "/":
                                newBarcode = newBarcode + "2"
                                break;
                            case "-":
                                newBarcode = newBarcode + "3"
                                break;
                            case "ภ":
                                newBarcode = newBarcode + "4"
                                break;
                            case "ถ":
                                newBarcode = newBarcode + "5"
                                break;
                            case "ุ":
                                newBarcode = newBarcode + "6"
                                break;
                            case "ึ":
                                newBarcode = newBarcode + "7"
                                break;
                            case "ค":
                                newBarcode = newBarcode + "8"
                                break;
                            case "ต":
                                newBarcode = newBarcode + "9"
                                break;
                            case "จ":
                                newBarcode = newBarcode + "0"
                                break;
                            default:
                                break;
                        }
                    }
                    break;
                default:
                    break;
            }

            if (newBarcode != "") {
                barcode = newBarcode
            }

            if (barcode.length > 0) {
                $.ajax({
                    type: "get",
                    url: "./backend/pos.php?barcode=" + barcode + "&func=searchProduct",
                    success: function(res) {
                        if ((typeof res) == "object") {
                            let item = {};
                            item = {
                                id: Date.now(),
                                name: res['name'],
                                price: parseInt(res['price']),
                                qty: 1
                            }
                            basket.push(item);
                            calculate();
                            $("#change").val("");
                        } else {
                            alert("ไม่พบรายการสินค้าที่ค้นหา")
                        }
                        $("#barcode").val("") //clear barcode input
                    }
                });
            }
        }
        // ----- End function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----

        // ----- Start Event กดปุ่มบน keyboard -----
        $(document).on('keypress', function(e) {
            // ----- Start Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----
            if (e.which == 13) {
                searchHandle()
            }
            // ----- End Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----

            // ----- Start Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน -----   
            if (e.keyCode == 32) {
                let sum_value = $("#sum").val();
                if (sum_value == "") {
                    alert("ยังไม่มีรายการสินค้าที่ต้องคำนวณ")
                    $("#barcode").val("");
                    //return false
                } else {
                    window.setTimeout(() => $("#receive").focus(), 0);
                }
            }
            // ----- End Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน ----- 

            // F5
            if (e.keyCode === 116) {
                e.preventDefault();
                clear();
            }
        });
        // ----- End Event กดปุ่มบน keyboard -----


        // ----- Start Event change input รับเงิน -----
        $("#receive").on("keyup", () => {
            const receive = $("#receive").val();
            if (receive > 0) {
                let x = receive - $("#sum").val();
                $("#change").val(x)
            }
        })
        // ----- End Event change input รับเงิน -----


        // ----- Start Event คลิ๊กปุ่ม ค้นหา -----
        $("#search").on("click", () => {
            searchHandle();
        })
        // ----- End Event คลิ๊กปุ่ม ค้นหา -----

        // ----- Start Event คลิ๊กปุ่ม clear -----
        $("#clear").on("click", () => {
            clear();
        })
        // ----- End Event คลิ๊กปุ่ม clear -----

        const clear = () => {
            basket = [];
            calculate();
            $("#receive").val(null);
            $("#sum").val(null);
            $("#change").val(null);
            $('#barcode').focus();
        }
    });
</script>