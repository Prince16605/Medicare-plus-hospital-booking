<?php
// MediCare Plus - Hospital Appointment Handler
// Demo appointment handler.
// Add your database connection when ready.

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}


// ======================================================
// GET AND SANITIZE FORM VALUES
// ======================================================

$name       = trim($_POST["name"] ?? "");
$mobile     = trim($_POST["mobile"] ?? "");
$doctor     = trim($_POST["doctor"] ?? "");
$date       = trim($_POST["date"] ?? "");
$time       = trim($_POST["time"] ?? "");
$reason     = trim($_POST["reason"] ?? "");


// ======================================================
// VALIDATION
// ======================================================

$errors = [];


// Patient Name

if ($name === "" || strlen($name) < 2) {
    $errors[] = "Please enter a valid patient name.";
}


// Mobile Number

if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
    $errors[] = "Please enter a valid 10-digit Indian mobile number.";
}


// Allowed Doctors

$allowedDoctors = [
    "Dr. Rajesh Mehta - Cardiologist",
    "Dr. Priya Shah - Neurologist",
    "Dr. Amit Patel - Orthopedic Surgeon",
    "Dr. Neha Desai - Dermatologist",
    "Dr. Kunal Joshi - Pediatrician",
    "Dr. Anjali Sharma - Gynecologist"
];

if (!in_array($doctor, $allowedDoctors, true)) {
    $errors[] = "Please select a valid doctor.";
}


// Appointment Date

if ($date === "") {

    $errors[] = "Please select an appointment date.";

} else {

    $dateObject = DateTime::createFromFormat("Y-m-d", $date);

    if (!$dateObject || $dateObject->format("Y-m-d") !== $date) {

        $errors[] = "Please select a valid appointment date.";

    } else {

        $today = new DateTime("today");

        if ($dateObject < $today) {
            $errors[] = "Appointment date cannot be in the past.";
        }
    }
}


// Allowed Appointment Times

$allowedTimes = [
    "09:00 AM",
    "10:00 AM",
    "11:00 AM",
    "12:00 PM",
    "02:00 PM",
    "03:00 PM",
    "04:00 PM",
    "05:00 PM"
];

if (!in_array($time, $allowedTimes, true)) {
    $errors[] = "Please select a valid appointment time.";
}


// Reason is optional
// No validation required.


// ======================================================
// ERROR PAGE
// ======================================================

if (!empty($errors)) {
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Appointment Error - MediCare Plus
    </title>


    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

            font-family: Arial, sans-serif;

            background: #f4fafb;

            color: #17384f;
        }


        .card {

            width: 100%;

            max-width: 550px;

            background: #ffffff;

            padding: 40px;

            border-radius: 20px;

            box-shadow:
                0 20px 55px rgba(20, 70, 90, .10);

            border: 1px solid #e5eef1;
        }


        .error-icon {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            background: #fff0f0;

            color: #d94b4b;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 35px;

            font-weight: bold;

            margin-bottom: 20px;
        }


        h1 {

            margin-top: 0;

            color: #173d56;

            font-size: 28px;
        }


        .subtitle {

            color: #718391;

            line-height: 1.6;
        }


        ul {

            padding-left: 20px;

            color: #5e707d;
        }


        li {

            margin: 10px 0;
        }


        .btn {

            display: inline-block;

            margin-top: 20px;

            padding: 13px 20px;

            border-radius: 9px;

            background: #087f8c;

            color: white;

            text-decoration: none;

            font-weight: 700;
        }


        .btn:hover {

            background: #056b76;
        }

    </style>

</head>


<body>

    <div class="card">

        <div class="error-icon">
            !
        </div>


        <h1>
            Appointment Not Submitted
        </h1>


        <p class="subtitle">
            Please correct the following errors and try again:
        </p>


        <ul>

            <?php foreach ($errors as $error): ?>

                <li>
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </li>

            <?php endforeach; ?>

        </ul>


        <a
            href="index.html"
            class="btn"
        >
            ← Back to Appointment
        </a>

    </div>

</body>

</html>

<?php

    exit;
}


// ======================================================
// GENERATE APPOINTMENT ID
// ======================================================

$appointmentId =
    "MC" .
    date("Ymd") .
    strtoupper(substr(uniqid(), -6));


// ======================================================
// FORMAT DATE FOR DISPLAY
// ======================================================

$displayDate = date(
    "d M Y",
    strtotime($date)
);


// ======================================================
// SAFE DISPLAY VALUES
// ======================================================

$safeName = htmlspecialchars(
    $name,
    ENT_QUOTES,
    'UTF-8'
);

$safeMobile = htmlspecialchars(
    $mobile,
    ENT_QUOTES,
    'UTF-8'
);

$safeDoctor = htmlspecialchars(
    $doctor,
    ENT_QUOTES,
    'UTF-8'
);

$safeDate = htmlspecialchars(
    $displayDate,
    ENT_QUOTES,
    'UTF-8'
);

$safeTime = htmlspecialchars(
    $time,
    ENT_QUOTES,
    'UTF-8'
);

$safeReason = htmlspecialchars(
    $reason,
    ENT_QUOTES,
    'UTF-8'
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Appointment Confirmed - MediCare Plus
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            font-family: Arial, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #eefafa,
                    #f7fbff
                );

            color: #17384f;
        }


        .page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 18px;
        }


        .card {

            width: 100%;

            max-width: 680px;

            background: white;

            border-radius: 24px;

            padding: 45px;

            text-align: center;

            box-shadow:
                0 25px 70px rgba(20, 65, 85, .13);

            border: 1px solid #e4eef1;
        }


        .success-icon {

            width: 82px;

            height: 82px;

            margin: 0 auto 22px;

            border-radius: 50%;

            background: #e1f7ee;

            color: #159368;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 43px;

            font-weight: bold;
        }


        h1 {

            margin: 0 0 10px;

            font-size: 32px;

            color: #123b55;
        }


        .subtitle {

            color: #718391;

            line-height: 1.7;

            margin-bottom: 25px;
        }


        .appointment-id {

            display: inline-block;

            background: #e8f7f7;

            color: #087f8c;

            padding: 12px 19px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 800;

            letter-spacing: .7px;
        }


        .details {

            text-align: left;

            background: #f8fbfc;

            border: 1px solid #e4edef;

            border-radius: 17px;

            padding: 20px;

            margin: 28px 0;
        }


        .row {

            display: flex;

            justify-content: space-between;

            gap: 20px;

            padding: 14px 0;

            border-bottom:
                1px solid #e6edef;
        }


        .row:last-child {

            border-bottom: none;
        }


        .label {

            color: #71818d;

            font-size: 14px;
        }


        .value {

            color: #183d55;

            font-weight: 700;

            font-size: 14px;

            text-align: right;
        }


        .doctor-box {

            background: #eefafa;

            border: 1px solid #d7eeee;

            border-radius: 13px;

            padding: 15px;

            margin-bottom: 20px;

            text-align: left;
        }


        .doctor-box-title {

            color: #087f8c;

            font-size: 12px;

            font-weight: 800;

            margin-bottom: 5px;

            text-transform: uppercase;

            letter-spacing: .8px;
        }


        .doctor-box-name {

            color: #183d55;

            font-weight: 800;

            font-size: 16px;
        }


        .note {

            color: #788893;

            font-size: 13px;

            line-height: 1.7;

            margin-top: 22px;
        }


        .buttons {

            display: flex;

            justify-content: center;

            gap: 12px;

            flex-wrap: wrap;

            margin-top: 25px;
        }


        .btn {

            display: inline-block;

            padding: 13px 22px;

            border-radius: 9px;

            text-decoration: none;

            font-weight: 700;

            font-size: 14px;
        }


        .primary-btn {

            background: #087f8c;

            color: white;
        }


        .secondary-btn {

            background: white;

            color: #087f8c;

            border: 1px solid #cfe3e7;
        }


        .primary-btn:hover {

            background: #056c76;
        }


        .secondary-btn:hover {

            background: #f1fafa;
        }


        @media (max-width: 600px) {

            .card {

                padding: 30px 20px;
            }


            h1 {

                font-size: 27px;
            }


            .row {

                flex-direction: column;

                gap: 5px;
            }


            .value {

                text-align: left;
            }

        }

    </style>

</head>


<body>


<div class="page">


    <div class="card">


        <!-- SUCCESS ICON -->

        <div class="success-icon">
            ✓
        </div>


        <!-- TITLE -->

        <h1>
            Appointment Request Received!
        </h1>


        <p class="subtitle">

            Thank you,
            <strong><?= $safeName ?></strong>.

            Your appointment request has been
            successfully submitted to MediCare Plus.

        </p>


        <!-- APPOINTMENT ID -->

        <div class="appointment-id">

            Appointment ID:
            <?= htmlspecialchars(
                $appointmentId,
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>


        <!-- DOCTOR -->

        <div class="doctor-box">

            <div class="doctor-box-title">
                Selected Doctor
            </div>

            <div class="doctor-box-name">
                <?= $safeDoctor ?>
            </div>

        </div>


        <!-- DETAILS -->

        <div class="details">


            <div class="row">

                <span class="label">
                    Patient Name
                </span>

                <span class="value">
                    <?= $safeName ?>
                </span>

            </div>


            <div class="row">

                <span class="label">
                    Mobile Number
                </span>

                <span class="value">
                    <?= $safeMobile ?>
                </span>

            </div>


            <div class="row">

                <span class="label">
                    Appointment Date
                </span>

                <span class="value">
                    <?= $safeDate ?>
                </span>

            </div>


            <div class="row">

                <span class="label">
                    Appointment Time
                </span>

                <span class="value">
                    <?= $safeTime ?>
                </span>

            </div>


            <?php if ($reason !== ""): ?>

            <div class="row">

                <span class="label">
                    Reason for Visit
                </span>

                <span class="value">
                    <?= $safeReason ?>
                </span>

            </div>

            <?php endif; ?>


        </div>


        <!-- NOTE -->

        <p class="note">

            Our hospital team will contact you on your
            registered mobile number to confirm the
            appointment.

            Please arrive approximately 10 minutes
            before your scheduled appointment time.

        </p>


        <!-- BUTTONS -->

        <div class="buttons">

            <a
                href="index.html"
                class="btn primary-btn"
            >
                ← Back to Home
            </a>


            <a
                href="index.html#doctors"
                class="btn secondary-btn"
            >
                Find Another Doctor
            </a>

        </div>


    </div>

</div>


</body>

</html>