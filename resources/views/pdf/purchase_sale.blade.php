<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase and Sale Agreement</title>

    <style>
        input {
            text-align: center;
        }

        input:focus {
            border-bottom: 1px solid #000;
            border: none;
        }

        input:focus-visible {
            border-bottom: 1px solid #000;
            border: none;
            outline: none;
        }

        .pdf_w {
            width: 100%;
            margin: auto;
        }

        body {
            font-family: sans-serif;
            margin: 0;
        }

        .txt-cntr {
            text-align: center;
        }

        .txt-lft {
            text-align: left;
        }

        td {
           line-height: 1;
            /* padding-top: 10px !important;
            padding-bottom: 10px !important; */
        }

        p {
            font-size: 12px;
            margin-top: 3px;
            margin-bottom: 3px;
        }
        span {
            font-size: 12px;
        }
        h4 {
            margin-top: 5px;
            margin-bottom: 5px
        }
        .ern_mny_dpst {
            padding: 0px 78px 0 0;
        }

        .csh_slr_clsng {
            padding: 0px 65px 0px 0;
        }

        .ext_ln {
            padding: 0px 81px 0px 0;
        }

        .nw_ln_slr_clsng {
            padding: 0px 39px 0px 0;
        }

        .prchs_prc {
            padding: 0px 120px 0px 0;
        }

        table {
            margin: 0;
            border-spacing: 0;
        }

        input {
            font-weight:800;
            font-family: sans-serif;
        }
    </style>
</head>

<body>
<table class="pdf_w txt-cntr">
    <tr>
        <th>
            <h4>
                Purchase and Sale Agreement
            </h4>
        </th>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    This agreement is made this
                    <input value="{{$day}}" style="border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    day of <input value="{{$month}}"  style="border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    20 <input value="{{$year}}" style="border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    between Seller(s)<input value="{{$between_seller}}" style="width: 500px; border: none; border-bottom: 1px solid #ccc; "
                                            type="text" name="day" />
                    Social Security # <input value="{{$social_security_number}}" style="border: none; border-bottom: 1px solid #ccc;" type="text"
                                             name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    and Buyer <input value="{{$between_buyer}}" style="width: 842px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <p>
                        and or assignees. Seller agrees to sell and buyer agrees to buy the following described real
                        property together with all improvements and fixtures
                        and the personal property described below:
                    </p>
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Street Address <input value="{{$street_address}}" style="width: 815px; border: none; border-bottom: 1px solid #ccc; "
                                          type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Legal Description: <input value="{{$city}}" style="width: 390px; border: none; border-bottom: 1px solid #ccc; "
                                              type="text" name="day" /> <input value="{{$state}}"
                        style="width: 180px; border: none; border-bottom: 1px solid #ccc; " type="text" name="day" />
                    <input value="{{$zip}}" style="width: 205px; border: none; border-bottom: 1px solid #ccc; " type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Country: <input value="{{$country}}" style="width: 350px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                    name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Personal property included: <input value="{{$personal_property_included}}"
                        style="width: 725px; border: none; border-bottom: 1px solid #ccc; " type="text" name="day" />
                </span>
        </td>
    </tr>
</table>
        <table style=" margin: auto;" class="center-table">
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <span class="ern_mny_dpst">
                                Earnest Money Deposit
                            </span>
                            $ <input value="{{$earn_money_deposit}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <span class="csh_slr_clsng">
                                Cash To Seller At Closing
                            </span>
                            $ <input value="{{$cash_to_seller}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <span class="ext_ln">
                                Existing Loans & Liens
                            </span>
                            $ <input value="{{$existing_loans}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                        </span>
                </td>
            </tr>
            <tr>
                <td class="txt-lft">
                        <span>
                            <span class="nw_ln_slr_clsng">
                                New Loan To Seller At Closing
                            </span>
                            $ <input value="{{$new_loans_to_seller}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <span class="prchs_prc">
                                Purchase Price
                            </span>
                            $ <input value="{{$sale_price}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                     name="day" />
                        </span>
                </td>
            </tr>
        </table>
        <table class="pdf_w">
            <tr>
                <td class="txt-lft">
                    <p>
                        The purchase price to be paid as follows:
                    </p>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>1. EARNEST MONEY </strong> is not refundable.
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>2. THE BALANCE DUE SELLER </strong> in the amount of $ <input value="{{$balace_due_seller}}"
                                style="border: none; border-bottom: 1px solid #ccc; " type="text" name="day" /> shall be
                            paid as follows: <input value="{{$amount_to_be_paid}}" style="width: 400px; border: none; border-bottom: 1px solid #ccc; "
                                                    type="text" name="day" />
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>3. PRORATIONS, IMPOUNDS & SECURITY DEPOSITS:</strong> Loan interest, property taxes,
                            insurance, and
                            rents shall be prorated as of the date of
                            closing. All security deposits shall be transferred to buyer at closing. All impound
                            accounts for taxes and insurance are included in the purchase
                            price and shall be transferred to buyer at closing. Any shortage in these accounts shall be
                            charged to seller at closing.
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>4. BUYER WILL PAY ALL CLOSING COST MINUS ANY UNPAID TAXES, MORTGAGES OR
                                LIENS</strong>
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        {{-- @php
                            $close_day_month = $explode('-', $close_day_month);
                            if(count($close_day_month) != 2) {
                                $close_day_month = $explode('/', $close_day_month);
                            }
                        @endphp --}}
                        <span>
                            <strong>5. CLOSING DATE AND TRANSFER OF TITLE: </strong> This transaction shall close on or
                            before <input value="{{$close_day_month}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; "
                                          type="text" name="day" />, 20 <input value="{{ $losing_year }}"
                                style="width: 40px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                name="day" />. Closing will be held at
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <input value="{{$closing_held}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                                   name="day" /> and Seller(s) agree to transfer marketable title free and clear of all
                            encumbrances except those listed and
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            pay any required state taxes or stamps required to record deed and mortgage. Seller agrees
                            to furnish title insurance in the amount of the
                        </span>
                </td>
            </tr>
            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            purchase price, showing no encumbrances or exceptions other than previously noted.
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>6. DAMAGE TO PROPERTY:</strong> Seller shall maintain property in its current
                            condition and keep it
                            insured against all loss until closing in the event
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            of destruction covered by insurance, buyer may elect to close and collect the insurance
                            proceeds.
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>7. DEFAULTS: </strong> If buyer defaults under this contract, any and all monies
                            deposited by buyer(s) shall be retained by seller as full liquidated
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            damages. If seller defaults, buyer may pursue all remedies allowed by law and sellers
                            default.
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>8. SUCCESSORS AND ASSIGNEES:</strong> The terms and conditions of this contract
                            shall bind all successors, heirs, administrators, trustees
                        </span>
                    <p>
                        executors and assignees of the respective parties.
                    </p>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>9. ACCESS ADVERTISING AND REPAIRS MADE BY BUYERS:</strong> Sellers agree that buyers
                            may advertise property and have access during
                        </span>
                    <p>
                        reasonable hours to show property to others. If the property is vacant and in need of
                        repairs, buyers at their expense may make repairs and
                    </p>
                    <p>
                        improvements, and any improvements made shall become the property of the seller should the
                        buyer default,
                    </p>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>10. The Liability shall be limited to the property itself and shall not extend
                                beyond.</strong>
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            <strong>11. This contract constitutes the entire agreement between Purchaser and Seller
                                regarding the property and
                                supercedes all prior discussions, negotiations and agreements whether oral or
                                written.</strong>
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            THIS IS INTENDED TO BE A LEGALLY BINDING CONTRACT, IF YOU DO NOT UNDERSTAND THE LEGAL EFFECT
                            OF ANY PART OF <br />
                            THIS CONTRACT, SEEK LEGAL ADVICE BEFORE SIGNING.
                        </span>
                </td>
            </tr>

            <tr class="txt-cntr">
                <td class="txt-lft">
                        <span>
                            Buyer will have a <input style="width: 50px; border: none; border-bottom: 1px solid #ccc; "
                                                     type="text" name="day" /> day inspection period and has the right to cancel this
                            agreement with written notice to the seller within the <br /> inpsection period. Inspection
                            period starts when the last party has signed this agreement.
                        </span>
                </td>
            </tr>

            <tr>
                <td class="txt-lft">
                    <h4 style="margin-bottom: 0px; padding-bottom: 0;">SELLERS:</h4><br />
                    <input style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                           name="day" /> <br /> <br/>
                    <input style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                           name="day" />
                </td>
            </tr>

            <tr>
                <td class="txt-lft">
                    <h4 style="margin-bottom: 0px; padding-bottom: 0;">BUYERS:</h4><br />
                    <input style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                           name="day" /> <br /> <br/>
                    <input style="width: 200px; border: none; border-bottom: 1px solid #ccc; " type="text"
                           name="day" />
                </td>
            </tr>

        </table>
</body>

</html>
