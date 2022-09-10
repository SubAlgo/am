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
                <div class="col-md-4 text-right text-muted"><br /><span>รวมจำนวนสินค้า x ชิ้น </span></div>
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
                        <th style="width: 10%">ลบรายการ</th>
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
                                <td class="f-26">รับเงิน</td>
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
                    <div class="btn-group btn-group-cal" role="group" aria-label="">
                        <button type="button" class="btn btn-success" id="cal">คิดเงินทอน <br /> [Enter]</button>
                        <button type="button" class="btn btn-outline-danger" id="clear">ล้างข้อมูล <br /> [F5]</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#barcode').focus()

        let eid = 0; //สำหรับกำหนดค่าให้ element id

        let price = []; //array ราคาสินค้าต่อชิ้น
        let qty = []; //array จำนวนสินค้า
        let total = []; //array ราคารวมสินค่าต่อรายการ [price * qty]
        let sum = 0;
        let result = 0; //ผลรวมราคาสินค้าทั้งหมด
        let v = 0;
        let s = 0;

        let show = 1;
        let showList = [];

        // ----- Start fucntion สำหรับผลรวมราคาสินค้าทั้งหมด -----
        let calSum = (x) => {
            x.reduce((sum, number) => {
                let r = sum + number
                $(`#sum`).val(sum + number)
                console.log(`result : ${r}`)
                return sum + number
            }, 0)
        }
        // ----- End fucntion สำหรับผลรวมราคาสินค้าทั้งหมด -----



        // ----- Start function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----
        let searchHandle = () => {
            let barcode = $("#barcode").val()
            barcode = barcode.trim()

            // check char is not Thai charactor
            let firstCharOfBarcode = barcode.charCodeAt(0)
            // console.log(firstCharOfBarcode)
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

            // var str = "HELLO WORLD";
            // var n = str.charCodeAt(0);
            if (barcode.length > 0) {
                $.ajax({
                    type: "get",
                    url: "./backend/pos.php?barcode=" + barcode + "&func=searchProduct",
                    success: function(res) {
                        if ((typeof res) == "object") {
                            let num = eid;
                            price[num] = res['price'];
                            qty[num] = 1;
                            total[num] = price[num] * qty[num];
                            console.log(res['name'])
                            console.log(res['price'])

                            $("#change").val("");



                            let e_tr = $(`<tr id='list${num}'></tr>`);

                            let e_no = $(`<th class='text-center pt-1 pb-1' >
                                            <span id='order${num}'>${show}</span>
                                        </th>`);
                            show = show + 1;
                            showList.push(1);
                            console.log(`showList ${showList}`);

                            //สร้าง Element ช่องแสดงชื่อสินค้า
                            let e_name = $(`<td class="pt-1 pb-1" >
                                            <span id='name${num}'>${res['name']}</span>
                                        </td>`);

                            //สร้าง Element container ของ ช่องกำหนดปริมาณสินค้าที่ขาย
                            let e_containet_qty = $(`<td class="pt-1 pb-1 text-center" id="container-qty${num}" >
                                        </td>`);

                            //สร้าง Element ช่องกำหนดปริมาณสินค้าที่ขาย
                            let e_qty = $(`<input class="text-center form-control form-control-sm" type="number" id="qty${num}" value="${qty[num]}" style="width: 70px">`)
                                // Event เปลี่ยนจำนวนสินค้า
                                .on("change", () => {
                                    v = $(`#qty${num}`).val();
                                    s = v * price[num]
                                    $(`#total${num}`).text(s)
                                    total[num] = s
                                    console.log(total)
                                    //คำนวณผลรวมของราคาสินค้าทั้งหมด เมื่อมีการเปลี่ยนจำนวนสินค้า
                                    result = calSum(total)
                                    $("#change").val("")
                                });

                            //สร้าง Element ช่องแสดงราคาของสินค้า
                            let e_price = $(`<td class="text-center pt-1 pb-1">
                                                <span class="text-center pt-0 pb-0" id="price${num}">
                                                    ${price[num]}
                                                </span>
                                            </td>`);

                            //สร้าง Element ช่องแสดงผลลัพธ์ราคารวมของรายการ [price * qyt]
                            let e_total = $(`<td class="text-center pt-1 pb-1">
                                                <span id="total${num}">
                                                    ${total[num]}
                                                </span>
                                            </td>`);

                            //สร้าง Element ปุ่มลบ list แถวรายการสินค้า

                            // ----- Start function สำหรับจัดการเลขแสดงลำดับหน้า List -----
                            let editNumberList = () => {
                                let i;
                                let j = 1;
                                let ck = 0; //ตัวแปร สำหรับเช็คว่ามีรายการสินค้าใน list หรือ ไม่

                                // กำหนดเพื่อเป็น index ในการบอกว่า list ลำดับนี้ถูกลบไปแล้ว
                                // คือ 1 = list ลำดับยังมีอยู่
                                // 2 = list ลำดับถูกลบไปแล้ว
                                //showList[`${num}`] = 0;
                                showList[`${num}`] = 0;

                                // total คือ array ของราคารวมในในแต่ละแถว [จำนวน * ราคาต่อชิ้น]
                                total[num] = 0;

                                for (i = 0; i < showList.length; i++) {
                                    if (showList[i] != 0) {
                                        $(`#order${i}`).text(`${j}`)
                                        j = j + 1;
                                        show = j;

                                        ck = ck + showList[i]
                                    }
                                }

                                /**
                                   ถ้าตัวแปร ck มีค่าเท่ากับ 0 แปลว่า ไม่มีรายการใน list แล้ว 
                                   ก็จะทำการ set เลขลำดับการโชว์ใหม่เป็น 1
                                   และ clear ค่าในตัวแปรทั้งหมด
                                */

                                if (ck == 0) {
                                    show = 1;
                                    eid = 0; //สำหรับกำหนดค่าให้ element id
                                    price = []; //array ราคาสินค้าต่อชิ้น
                                    qty = []; //array จำนวนสินค้า
                                    total = []; //array ราคารวมสินค่าต่อรายการ [price * qty]
                                    showList = [];
                                    sum = 0;
                                    result = 0;
                                    $(`#sum`).val("")
                                }

                                result = calSum(total);
                                $(`#list${num}`).remove();
                            }
                            // ----- End function สำหรับจัดการเลขแสดงลำดับหน้า List -----

                            let e_close = $(`<td class="text-center pt-1 pb-1">
                                                <span class="btn btn-danger pt-0 pb-0" id="del${num}">X</span>
                                            </td>`).on("click", () => {



                                //เรียกใช้ function editNumberList() เพื่อปรับเปลี่ยนลำดับการแสดงผลหน้า list
                                editNumberList();
                                console.log(`showList ${showList}`);


                                console.log(total);
                            });


                            // ----- Start append Element to list -----
                            $("#saleList").append(e_tr);

                            $(e_tr).append(e_no);
                            $(e_tr).append(e_name);
                            $(e_tr).append(e_containet_qty);
                            $(e_containet_qty).append(e_qty);
                            $(e_tr).append(e_price);
                            $(e_tr).append(e_total);
                            $(e_tr).append(e_close);
                            // ----- End append Element to list -----

                            eid = eid + 1;

                            //คำนวณผลรวมของราคาสินค้าทั้งหมด เมื่อมีการเพิ่มรายการสินค้า
                            result = calSum(total)



                        } else {
                            alert("ไม่พบรายการสินค้าที่ค้นหา")
                        }

                        //alert("fuck: " + eid)
                        $("#barcode").val("") //clear barcode input
                    }
                });
            }
        }
        // ----- End function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----

        // ----- Start function คำนวณเงินทอน -----
        let cal = () => {
            let sum_value = $("#sum").val();
            let rec_value = $("#receive").val();
            if (sum_value > 0 && rec_value > 0) {

                let x = rec_value - sum_value;
                $("#change").val(x);
                $("#receive").focus();
                return
            }
        }
        // ----- End function คำนวณเงินทอน -----


        // ----- Start Event เหตุการณ์ กดปุ่ม คิดเงินทอน -----
        $("#cal").on("click", () => {
            cal();
        })
        // ----- End Event เหตุการณ์ กดปุ่ม คิดเงินทอน -----



        // ----- Start Event กดปุ่มบน keyboard -----
        $(document).on('keypress', function(e) {
            //console.log(e);


            // ----- Start Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----
            if (e.which == 13) {
                searchHandle()
            }
            // ----- End Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----

            // ----- Start Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน -----   
            if (e.keyCode == 32) {
                let sum_value = $("#sum").val();

                console.log(sum_value);
                if (sum_value == "") {
                    alert("ยังไม่มีรายการสินค้าที่ต้องคำนวณ")
                    $("#barcode").val("");
                    //return false
                } else {
                    window.setTimeout(() => $("#receive").focus(), 0);
                }

            }
            // ----- End Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน ----- 


        });
        // ----- End Event กดปุ่มบน keyboard -----


        // ----- Start Event change input รับเงิน -----
        $("#receive").on("keyup", () => {
            let x = $("#receive").val() - $("#sum").val();
            $("#change").val(x)
        })
        // ----- End Event change input รับเงิน -----


        // ----- Start Event คลิ๊กปุ่ม ค้นหา -----
        $("#search").on("click", () => {
            searchHandle();
        })
        // ----- End Event คลิ๊กปุ่ม ค้นหา -----

        // ----- Start Event คลิ๊กปุ่ม clear -----
        $("#clear").on("click", () => {
            location.reload();
        })
        // ----- End Event คลิ๊กปุ่ม clear -----







    });
</script>