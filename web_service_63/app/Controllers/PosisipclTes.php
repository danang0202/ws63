<?php

namespace App\Controllers;

use App\Libraries\Posisipcl;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PosisipclModel;

class PosisipclTes extends ResourceController
{
    use ResponseTrait;

    //$posisipclModel = new PosisipclModel();

    public function getAllPosPCL()
    {
        $posisipclModel = new PosisipclModel();

        $nama_tim = $this->request->getPost('nama_tim');

        $object = $posisipclModel->getPosisipcl($nama_tim);

        return $this->respond($object);
    }

    public function getPosPCL()
    {
        $posisipclModel = new PosisipclModel();

        $nim = $this->request->getPost('nim');

        $object = $posisipclModel->getPosisipcl($nim);

        return $this->respond($object);
    }
}
?>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin="">
</script>

<script>
    let markersLayers = new L.LayerGroup();
    let map = L.map('mapid').setView([0, 118.9213], 5);
    let date = new Date();
    let datetime = date.getFullYear() + ' bulan ' + (date.getMonth() + 1).toString().padStart(2, '0') + ' tanggal ' + (date.getDate())
        .toString().padStart(2, '0') + ' jam ' + date.getHours() + ':00';
    let tanggal = document.querySelector('.tanggal');
    tanggal.textContent = datetime
    // console.log(datetime);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    getData();
    async function getData() {
        markersLayers.clearLayers();
        let aG = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml';
        let gT = 'https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.xml';
        let gD = 'https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.xml';
        let selectGempa = document.getElementById('selectGempa').value;
        if (selectGempa == 'autogempa') {
            apiUrl = aG;
        }

        if (selectGempa == 'gempaterkini') {
            apiUrl = gT;
        }

        if (selectGempa == 'gempadirasakan') {
            apiUrl = gD;
        }

        let response = await fetch(apiUrl);
        let xmlString = await response.text();
        let parse = new DOMParser();
        let xmlData = parse.parseFromString(xmlString, 'text/xml')
        let gempas = xmlData.querySelectorAll('gempa');

        // let point = xmlData.querySelectorAll('coordinates');
        // point.forEach((points) => {
        //     let titik = points.innerHTML;
        //     let titiks = titik.split(",", 2);
        //     lintang = titiks[0];
        //     bujur = titiks[1];
        //     // console.log(lintang);
        //     // console.log(bujur);
        //     let marker = L.marker([lintang, bujur],{
        //         icon: L.icon({
        //             iconUrl: 'iconVolcano/gempa1.png',
        //             iconSize: [50, 50],
        //             iconAnchor: [25, 25]
        //         })
        //     }).bindPopup('<strong></strong>')
        //     marker.addTo(map);
        // })

        gempas.forEach((gempa) => {
            let tanggal = gempa.children[0].innerHTML;
            let waktu = gempa.children[1].innerHTML;
            let magnitude = gempa.children[6].innerHTML;
            let kedalaman = gempa.children[7].innerHTML;
            let wilayah = gempa.children[8].innerHTML;
            let potensi = gempa.children[9].innerHTML;
            let pointss = gempa.querySelector('coordinates');
            let pointss1 = pointss.innerHTML;
            let pointss2 = pointss1.split(",", 2);
            lintang = pointss2[0];
            bujur = pointss2[1];

            // console.log(lintang); 
            // console.log(bujur);

            let marker = L.marker([lintang, bujur], {
                icon: L.icon({
                    iconUrl: 'iconVolcano/gempa1.png',
                    iconSize: [50, 50],
                    iconAnchor: [25, 25]
                })
            }).bindPopup('<strong>Tanggal: ' + tanggal + '<br>Waktu: ' + waktu +
                '<br>Kekuatan gempa: ' + magnitude + '<br>Kedalaman: ' + kedalaman +
                '<br>Wilayah: ' + wilayah + '</strong>')
            marker.addTo(markersLayers);
            markersLayers.addTo(map);

            // console.log(tanggal);
            // console.log(waktu);
            // console.log(magnitude);
            // console.log(kedalaman);
            // console.log(wilayah);
            // console.log(potensi);
        })
    }

    function refresh() {
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }
</script>