<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointment</title>
    <style>
        @page {
        size: A4;
        margin: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            position: relative;
            height: 297mm; /* Full A4 height */
        }

        .bottom-image {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .content{
            margin-left: 80px;
            margin-right: 80px;
        }

        .justify {
        text-align: justify;
        }

        .qr{
           width: 100px; 
        }
    </style>
</head>

<?php
function formatMalayDate($date) {
    $months = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April',
        '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'
    ];
    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = $months[date('m', $timestamp)];
    $year = date('Y', $timestamp);
    return "$day $month $year";
}
?>

<body>
    <?php echo $this->Html->image('top.png',['width'=>'100%','fullBase'=>true]); ?>

        <div class="content justify" style="padding-bottom: 100px">
            <div class="card-body px-0">
            <br/>
            <table border="0" class="" width="100%">
                <tr>
                    <td width="65%"></td>
                    <td width="12%">Surat Kami</td>
                    <td width="1%">:</td>
                    <td width="20%">UiTM/<?= h($appointment->reference_no) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Tarikh</td>
                    <td>:</td>
                    <td><?php echo formatMalayDate($appointment->date); ?></td>
                    
                </tr>
            </table>
            <br/>

        <div class="mx-5 justify">
            <div class="fw-bold capital">
            <strong><?php echo ($appointment->lecturer->name); ?></div></strong>
            Pensyarah Kanan <br/>
            Pusat Pengajian Sains Maklumat <br/>
            Fakulti Sains Maklumat <br/>
            UiTM Kampus Puncak Perdana<br/>
            40150 Shah Alam<br/>
            Selangor
            <br/><br/>

            Salam Sejahtera
            <br/><br/>

            Tuan/Puan
            <br/><br/>

            <style>
                .capital{
                    text-transform: uppercase;
                }
            </style>

            <div class="fw-bold capital mb-4">
                <strong>PELANTIKAN SEBAGAI RESOURCE PERSON (RP) BAGI PROGRAM SARJANA MUDA SAINS MAKLUMAT (KEPUJIAN) PENGURUSAN SISTEM MAKLUMAT (CDIM262)</strong>
                <br/><br/>
                <table border="0" class="text-start mt-3 mb-3">
                    <tr>
                        <td width="0%"><strong>KOD KURSUS</strong></td>
                        <td width="0%">:</td>
                        <td width="0%"><strong><?php echo ($appointment->subject->code); ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong>NAMA KURSUS</strong></td>
                        <td>:</td>
                        <td><strong><?php echo ($appointment->subject->name); ?></strong></td>
                    </tr>
                </table>
                <br/><br/>
            </div>

            Dengan hormatnya perkara di atas adalah dirujuk.
            <br/><br/>

            2. Dimaklumkan bahawa Tuan/Puan adalah dilantik sebagai Resource Person (RP) bagi Kod Kursus <strong><?php echo ($appointment->subject->code); ?></strong> mulai <strong><?= formatMalayDate($appointment->start_date); ?> hingga <?= formatMalayDate($appointment->end_date); ?></strong> di <strong><?php echo ($appointment->location); ?></strong>.
            <br/><br/>

            3. Pelantikan ini adalah berdasarkan kepakaran dan pengalaman tuan bagi kod kursus tersebut.
            Dengan ini tuan diberi tanggungjawab untuk menyumbang terhadap pembangunan program dan
            melaksanakan tugas dengan komited serta berdedikasi demi meningkatkan kualiti pembangunan
            akademik khususnya di peringkat Fakulti Sains Maklumat (FSM).
            <br/><br/>
            4. Sehubungan dengan itu, tuan diminta untuk menghubungi Ketua Pengajian Sains Maklumat
            mengenai tugasan di atas pelantikan ini.
            <br/><br/>

            Sekian, kerjasama dan keprihatinan tuan amatlah dihargai dan didahului dengan ucapan terima kasih.
            <br/><br/>

            <strong>
            <br/>"MALAYSIA MADANI"<br/>
            "BERKHIDMAT UNTUK NEGARA"
            <br/><br/>
            </strong>

            Saya yang menjalankan amanah,
            <br/><br/><br/>

            <table width="100%">
                <tr>
                    <td width="85%">
                        <strong><?php echo ($appointment->approval_name); ?></strong><br/>
                        <?php echo ($appointment->approval_post); ?> <br/>
                        Fakulti Sains Maklumat<br/>
                        <br/><br/>
                    </td>

                    <td width="5%" class="right">
                        <img src="http://localhost/ims566resourcepersonsystem/js/qr-pdf/qrcode.php?s=qrh&d=<?php echo $this->request->getUri(); ?>" class="qr" ?>
                    </td>
                </tr>
            </table>
        </div>

            
            <img src="<?= $this->Url->image('bottom.png', ['fullBase' => true]); ?>" class="bottom-image" />
</body>
</html>