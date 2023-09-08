<?php
var_dump($_POST);
?>
<div class="checkout_area mt_20 pb_50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-between">
                    <div class="col-lg-5 order-lg-2 mt_40">
                        <div class="right_succes chek_right">
                            <h3>ORDER INFO</h3>
                            <h2>Dynamo Kuwait</h2>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span>1</span>
                                    <h3>2001 - 2005, Time</h3>
                                </div>
                                <p>30 KD</p>
                            </div>
                            <div class="suc_item">
                                <div class="suc_child">
                                    <span>1</span>
                                    <h3>Dynamo Kuwait Jeresy</h3>
                                </div>
                                <p>15 KD</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 order-lg-1 mt_40">
                        <div class="check_out">
                            <h2>PAYMENT METHOD</h2>
                            <form action="?v=Payment">
                                <div class="shape_items">
                                    <input type="radio" checked="" name="out" id="out_1">
                                    <label for="out_1"><span></span>Knet</label>
                                </div>
                                <div class="shape_items">
                                    <input type="radio" name="out" id="out_2">
                                    <label for="out_2"><span></span>Visa / Master Card</label>
                                </div>
                                <div class="shape_items">
                                    <input type="radio" name="out" id="out_3">
                                    <label for="out_3"><span></span>WALLET <p>  ( 20 KD )</p></label>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mt_50 extre_h6">
                                <h6><strong>Total</strong></h6>
                                <span>45 KD</span>
                            </div>
                            <p>By clicking Pay Now, you agree to our <a href="#">Terms & Conditions</a></p>
                            <a href="#" class="button">CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>