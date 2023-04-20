<!DOCTYPE html>
<html lang="sk">

<?php include "html/head.html" ?>

<body class="bg-gray-50 dark:bg-gray-800" style="overscroll-behavior-y: contain;">

<?php include "html/nav.html" ?>

<div id="units">
    <div class="unit"></div>
    <div class="unit"></div>
</div>

<div id="unit"></div>

<div id="section" class="hidden">
    <div class="sec-item"></div>
    <div class="sec-item"></div>
</div>

<?php include "html/createSection.html" ?>

<?php include "html/createUnit.html" ?>

<?php include "html/sectionSettings.html" ?>


<div>
    <small style="display: block; margin-top: 10px" class="dark:text-white">Posledná aktualizácia:</small>
    <p id="lastUpdate" class="shadow bg-white dark:bg-gray-700 dark:text-white"></p>
</div>

<?php include "html/sectionHistory.html" ?>

</body>
<script src="js/nav/messages.js"></script>
<script src="js/unit/loadUnit.js"></script>
<script src="js/unit/loadUnits.js"></script>
<script src="js/section/loadSection.js"></script>
<script src="js/nav/navigateBack.js"></script>
<script src="js/settings/loadSettings.js"></script>
<script src="js/section/handleSectionSettings.js"></script>
<script src="js/unit/handleAddUnit.js"></script>
<script src="js/section/handleAddSection.js"></script>
<script src="js/graphs/dates.js"></script>

<!-- ... -->
<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>

<!-- DevExtreme theme -->
<link rel="stylesheet" href="graphs/Lib/css/dx.light.css">

<!-- DevExtreme library -->
<script type="text/javascript" src="graphs/Lib/js/dx.all.js"></script>

<script src="js/graphs/loadGraphs.js"></script>
<script>
    const messages = document.getElementById("notifications")
    if(window.navigator.onLine === false){
        appendMessage("danger","Internetové pripojenie neexistuje. Skontroluj pripojenie a skús znova.")
    }
    const units = document.getElementById("units")
    const unit = document.getElementById("unit")
    const section = document.getElementById("section")
    const history = document.getElementById("sec-history")
    const loadHistory = document.getElementById("show-history")
    const title = document.getElementById("title")
    const timestamp = document.getElementById("lastUpdate")
    // modals
    const sectionSettings = document.getElementById("section-settings")
    const settingsButton = document.getElementById("settings-button")
    const createUnit= document.getElementById("create-unit")
    const createUnitButton = document.getElementById("create-unit-button")
    const createSection = document.getElementById("create-section")
    const createSectionButton = document.getElementById("create-unit-button")

    let lastUnitId;
    let openedSectionId;
    openUnits();
</script>
<script src="js/libs/flowbite.min.js"></script>
<script src="js/libs/datepicker.min.js"></script>
<script src="js/nav/changeColorMode.js"></script>
</html>