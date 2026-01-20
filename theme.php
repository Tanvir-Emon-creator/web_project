<?php
session_start();

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light';
}

if (isset($_GET['toggle_theme'])) {
    $_SESSION['theme'] = ($_SESSION['theme'] === 'light') ? 'dark' : 'light';
}

echo $_SESSION['theme'];
