<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Closing Agreement</title>

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
            width: 1020px;
            margin: auto;
        }

        body {
            font-family: sans-serif;
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

        .ern_mny_dpst {
            padding: 0px 80px;
        }

        .csh_slr_clsng {
            padding: 0px 65px 0px 80px;
        }

        .ext_ln {
            padding: 0px 82px 0px 80px;
        }

        .nw_ln_slr_clsng {
            padding: 0px 28px 0px 80px;
        }

        .prchs_prc {
            padding: 0px 135px 0px 80px;
        }
    </style>
</head>

<body>
    <table class="pdf_w txt-lft">
        <tr>
            <th>
                <h2>
                    REAL ESTATE CLOSING AGREEMENT
                </h2>
            </th>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    Real Estate Closing Agreement <strong>(“Agreement”)</strong> is made and entered into as of
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <strong>
                        {{$date}},
                    </strong>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    Between
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <br />
                    {{$seller_name}}("Seller")
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <br />
                    {{$buyer_name}}("Buyer").
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Sale and Purchase of Property
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        Seller agrees to sell and convey to Buyer, and Buyer agrees to purchase from Seller, <br />the
                        real
                        property commonly known as
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <strong style="margin: 0; padding-left: 80px">
                        {{$property_address}} (“Property”),
                    </strong>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <p style="margin: 0; padding-left: 80px">
                        together with any improvements and appurtenances thereto, for the purchase price of
                        <br /><strong>{{$sale_price}}</strong> (“Purchase Price”), subject to the terms and <br /> conditions of this
                        Agreement.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Closing Date
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        The closing of the sale and purchase of the Property (the “Closing”) shall take place on
                        <br />or before <strong>{{$date}}</strong> at <strong>{{$location}}</strong>, or such
                        other date, <br />time and place as the parties may mutually agree upon.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <strong style="margin: 0; padding-left: 80px">
                        Earnest Deposit.
                    </strong>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <p style="margin: 0; padding-left: 80px">
                        Buyer shall deposit with [ESCROW AGENT NAME] an earnest deposit of<br /> {{$earnest_deposit}}
                        (“Earnest Deposit”) within [NUMBER OF<br /> DAYS] days of the execution of this Agreement. The
                        Earnest
                        Deposit shall be applied<br /> to the Purchase Price at Closing.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Title At
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        Closing, Seller shall convey to Buyer by general warranty deed, free and clear of all
                        <br />liens and encumbrances except as otherwise provided in this Agreement, good and
                        <br />marketable title to the Property in accordance with the terms of this Agreement.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Assigment Fees
                    </h3><br />
                    @foreach($assignment_fee as $fee)
                    <p style="margin: 0; padding-left: 80px">
                        {{$fee}}
                    </p>
                    @endforeach
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Prorations
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        Real estate taxes, assessments, and other charges for the current year and prior years
                        <br />shall be prorated as of the Closing Date on the basis of the most recent tax bills or
                        other
                        <br />evidence of such charges available at the time of Closing.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Closing Costs
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        Buyer shall pay all recording fees, title insurance premiums, survey costs, and other
                        <br />closing costs in connection with the Closing. Seller shall pay any real estate
                        <br />commissions and fees payable in connection with the sale of the Property.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Possession
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        Seller shall deliver possession of the Property to Buyer at Closing.
                    </p>
                </span>
            </td>
        </tr>
        
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Deposit Fee.
                    </h3><br />
                    <p style="margin: 0; padding-left: 25px">
                        In addition to the Purchase Price, Buyer shall pay a deposit fee of <strong>{{$closing_cost}} </strong> to <strong>{{$location}}</strong> at Closing. The deposit fee shall
                        be used to cover <br /> any expenses incurred by <strong>{{$location}}</strong> in
                        connection with holding and<br />disbursing the Earnest Deposit and the Purchase Price. Any
                        unused portion of the deposit fee<br />shall be refunded to Buyer at Closing.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Condition of Property
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        The Property shall be sold in its present condition, as-is, where-is, with all faults
                        and<br />
                        defects, subject to all applicable zoning, building and other laws, ordinances,
                        regulations<br /> and restrictions. Seller makes no warranties, express or implied, as to the
                        condition or <br />fitness of the Property for any particular use or purpose.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Contingencies
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        This Agreement is contingent upon [LIST OF ANY CONTINGENCIES, SUCH AS <br />
                        BUYER OBTAINING FINANCING OR SELLER REMOVING A LIEN FROM <br /> THE PROPERTY].
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Default
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        If either party defaults under this Agreement, the non-defaulting party may terminate <br />
                        this Agreement and retain any earnest money as liquidated damages.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Governing Law
                    </h3><br />
                    <p style="margin: 0; padding-left: 25px">
                        This Agreement shall be governed by and construed in accordance with the laws of the State of
                        <br />
                        <strong>{{$property_address}}.</strong>
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Entire Agreement
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        This Agreement constitutes the entire agreement between the parties and supersedes all <br />
                        prior negotiations, understandings, and agreements between the parties, whether written <br />or
                        oral.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Amendments
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        This Agreement may be amended or modified only by written agreement signed by <br />
                        both parties.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0; padding-left: 25px">
                        Counterparts
                    </h3><br />
                    <p style="margin: 0; padding-left: 80px">
                        This Agreement may be executed in counterparts, each of which shall be deemed an <br />
                        original, but all of which together shall constitute one and the same instrument.
                    </p>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <p style="margin: 0; padding-left: 25px">
                        IN WITNESS WHEREOF, the parties have executed this Agreement as of the date first written<br />
                        above.
                    </p>
                </span>
            </td>
        </tr>

        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0;">
                        SELLER: {{$seller_name}}
                    </h3>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    By:
                    <input style="width: 300px; border: none; border-bottom: 1px solid #000;"
                        type="text" name="day" />
                </span><br />
                <span>
                    Name:
                    <input style="width: 280px; border: none; border-bottom: 1px solid #000; "
                        type="text" name="day" />
                </span><br />
                <span>
                    Title:
                    <input style="width: 295px; border: none; border-bottom: 1px solid #000;" type="text" name="day" />
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    <h3 style="margin: 0;">
                        BUYER: {{$buyer_name}}
                    </h3>
                </span>
            </td>
        </tr>
        <tr>
            <td class="txt-lft">
                <span>
                    By:
                    <input style="width: 300px; border: none; border-bottom: 1px solid #000; "
                        type="text" name="day" />
                </span><br />
                <span>
                    Name:
                    <input style="width: 280px; border: none; border-bottom: 1px solid #000; "
                        type="text" name="day" />
                </span><br />
                <span>
                    Title:
                    <input style="width: 295px; border: none; border-bottom: 1px solid #000;" type="text" name="day" />
                </span>
            </td>
        </tr>
    </table>
</body>

</html>
