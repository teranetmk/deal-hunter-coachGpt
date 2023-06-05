<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Sale Agreement</title>

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
<table class="pdf_w txt-cntr">
    <tr>
        <th>
            <h2>
                LAND SALE AGREEMENT
            </h2>
        </th>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        SELLER(S):
                    </strong>
                    <input value="{{$seller}}" style="width: 300px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        BUYER(S):
                    </strong>
                    <input value="{{$buyer}}" style="width: 300px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    The Seller and Buyer above agree to sell and buy on the terms and conditions specified below, the
                    <br>
                    properties located in the County of <input style="border: none; border-bottom: 1px solid #ccc;"
                                                               type="text" name="day" />, State of <input style="border: none; border-bottom: 1px solid #ccc;"
                                                                                                          type="text" name="day" />, described as:
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        ASSESSOR’S PARCEL NUMBER:
                    </strong>
                    <input value="{{$assesstor_parcel_no}}" style="width: 300px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    <strong>
                        ACREAGE SIZE:
                    </strong>
                    <input value="{{$acreage_size}}" style="width: 200px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        LEGAL DESCRIPTION:
                    </strong>
                    <input value="{{$legal_description}}" style="width: 720px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        PROPERTY ADDRESS:
                    </strong>
                    <input value="{{$property_address}}" style="width: 720px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        PURCHASE PRICE:
                    </strong> Buyer will pay the purchase price of $
                    <input value="{{$shall_be_paid_amount}}" style="width: 150px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    to the Seller. Earnest money <br /> deposit of <input
                    value="{{$deposit}}" style="width: 150px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    will be deposit with title company within <input value="{{$days}}"
                        style="width: 50px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                    business days of contract execution.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        UTILITIES:
                    </strong> The present condition of all utility access to the property is accepted by Buyer.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        PROPERTY CONDITION:
                    </strong> Seller knows of no hazardous substances or petroleum products having
                    been <br />
                    placed, stored, or released from or on the real property by any person in violation of any law, nor
                    of any <br />
                    underground storage tanks having been located on the real property at any time.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        CLOSING, TITLE AND CONVEYANCE:
                    </strong> Closing to take place at: <input value="{{$place}}"
                        style="width: 100px; border: none; border-bottom: 1px solid #ccc;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Title company name, address: <input value="{{$title}}"
                        style="width: 350px; border: none; border-bottom: 1px solid #ccc; " type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    Seller is to convey title to Buyer by Warranty Deed. Buyer to pay <input value="{{$percentage}}"
                        style="width: 50px; border: none; border-bottom: 1px solid #ccc; " type="text" name="day" />% of
                    closing cost. While the
                    seller <br />
                    shall, prior to or at closing, satisfy all outstanding mortgages, deeds of trust and liens affecting
                    the subject <br />
                    property which are not specifically assumed by Buyer herein. Title shall be good and marketable,
                    subject <br />
                    only to (a) covenants, conditions and restrictions of record, (b) public, private utility easements
                    and roads <br />
                    and rights-of-way, (c) applicable zoning ordinances, protective covenants and prior mineral
                    reservations, <br />
                    (d) special and other assessments on the property, if any, (e) general taxes for the year owed and
                    subsequent <br />
                    years. Buyer reserves the right to market the property before closing to investors, partners, MLS,
                    or other <br />
                    parties. Seller represents that the property may be legally used as zoned and that no government
                    agency has <br />
                    served any notice to Seller requiring repairs, alterations or corrections of any existing condition
                    except as <br />
                    stated herein.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        CLOSING DATE AND TRANSFER OF TITLE:
                    </strong> <br /> This transaction shall close on or before <input value="{{$day_and_month}}"
                        style="width: 100px; border: none; border-bottom: 1px solid #ccc;" type="text"
                        name="day" />20<input value="{{$year}}" style="width: 50px; border: none; border-bottom: 1px solid #ccc;"
                                              type="text" name="day" />.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        APPRAISAL, SURVEY AND TERMITE INSPECTION:
                    </strong> Any appraisal of the property shall be the <br />responsibility of Buyer. A survey is not
                    required.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        POSSESSION AND TITLE:
                    </strong> Prior to closing the property shall remain in the possession of Seller.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        PRORATIONS:
                    </strong> Taxes for the current year, interest, maintenance fees, assessments, dues and rents, if
                    any, <br />
                    will be prorated through the Closing Date. If taxes for the current year vary from the amount
                    prorated at <br />
                    closing, the parties shall adjust the prorations when tax statements for the current year are
                    available
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        ACCESS & INSPECTION:
                    </strong> Seller shall make the Property reasonably accessible to Buyer, Buyer’s
                    <br />
                    partners, contractors, surveyors, and appraisers prior to Closing. This agreement is subject to a
                    satisfactory <br />
                    inspection of the property by Buyer. Should the property not pass satisfactory inspection said
                    contract is <br /> null and void.
                </span>
        </td>
    </tr>

    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        NO BROKER OR AGENTS:
                    </strong> The parties represent that neither party has employed the services of a real
                    <br />
                    estate broker or agent in connection with the property, or that if such agents have been employed,
                    that the
                    <br />
                    party employing said agent shall pay any and all expenses outside the closing of this agreement.
                </span>
        </td>
    </tr>

    <tr>
        <td class="txt-lft">
                <span>
                    Buyer will have a <input value="{{$number_of_days}}" style="width: 50px; border: none; border-bottom: 1px solid #ccc;"
                                             type="text" name="day" /> day inspection period and has the right to cancel this agreement with
                    written notice <br /> to the seller within the inspection period. Inspection period starts when the
                    last party has signed this <br /> agreement.
                </span>
        </td>
    </tr>

    <tr>
        <td class="txt-lft">
                <span>
                    This agreement is binding on the heirs, administrators, executors, personal representatives, and
                    assigns of <br />
                    Buyer and Seller. By signing, each party accepts this offer.
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        Seller:
                    </strong>
                    <input style="width: 300px; border: none;" type="text" name="day" />
                    <strong>
                        Date:
                    </strong>
                    <input style="width: 250px; border: none;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        Buyer:
                    </strong>
                    <input style="width: 300px; border: none;" type="text" name="day" />
                    <strong>
                        Date:
                    </strong>
                    <input style="width: 250px; border: none;" type="text" name="day" />
                </span>
        </td>
    </tr>
    <tr>
        <td class="txt-lft">
                <span>
                    <strong>
                        Buyer:
                    </strong>
                    <input style="width: 300px; border: none;" type="text" name="day" />
                    <strong>
                        Date:
                    </strong>
                    <input style="width: 250px; border: none;" type="text" name="day" />
                </span>
        </td>
    </tr>
</table>
</body>

</html>
