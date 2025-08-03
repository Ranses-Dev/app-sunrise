<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client Form - Sunshine For All</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #000;
        }

        h1,
        h2 {
            text-align: center;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .header-table td {
            border: none;
            padding: 4px;
        }

        .small-text {
            font-size: 11px;
        }

        .no-border {
            border: none;
        }

        .signature-section {
            margin-top: 30px;
        }

        .approval-section {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        .note {
            font-style: italic;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        input[type="text"] {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="bold">Client Number:</td>
            <td></td>
            <td class="bold text-right">Agency: Sunshine For All, Inc.</td>
        </tr>
    </table>

    <p class="small-text">
        Please submit copies only. All originals must be placed in the client’s file. All forms/documents must be
        submitted in the order listed below.
    </p>

    <table>
        <thead>
            <tr>
                <th colspan="2">ALL Documents / Forms are REQUIRED</th>
                <th>Agency’s Housing Specialist Initials</th>
                <th>CSSA Initials</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Client Proof of Income (SSI, Pay Stubs, etc.)</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Proof of Medical / Disability Care Expenses</td>
                <td>AG</td>
                <td></td>
                <td>(If Applicable)</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Rent Calculation Worksheet</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Tenants Based Program Utility Allowance Form</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Landlord / Participation Agreement</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Lease (if move-in)</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Lease Addendum (if move-in)</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Previous Rent Calculation Worksheet</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>9</td>
                <td>IRS W-9 Form (if move-in)</td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>10</td>
                <td>Financial Action Request Form <br><span class="small-text">(Stop payment for prior landlord if
                        move-out)</span></td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>11</td>
                <td>Financial Action Request Form <br><span class="small-text">(For new landlord if move-in)</span></td>
                <td>AG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" class="small-text no-border note">*This form also MUST be emailed to
                    Voicjsc@miamidade.gov</td>
            </tr>
        </tbody>
    </table>

    <h2>Household Information (including client)</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Fulltime Student? (18 & Over)*</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <p class="small-text">*Proof Required</p>

    <div class="signature-section">
        <p>Agency Approval: ______________________________________ Print Name: ____________________ date: ___________
        </p>
    </div>

    <div class="approval-section">
        <p class="bold">FOR CITY OF MIAMI USE ONLY:</p>
        <p>City of Miami Approval: __________________________________ Print Name: _____________________ date: __________
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr auto; margin-top: 40px;">
            <div></div>
            <div></div>
            <div>
                <div style="margin-bottom: 8px;">Housing Payment: $</div>
                <div style="margin-bottom: 8px;">Client Portion: $</div>
                <div><span style="font-weight: bold;">Total:</span> $</div>
            </div>
        </div>
    </div>

</body>

</html>
