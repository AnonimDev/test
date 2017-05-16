<?php

unset($_SESSION['user']); // Чистим сессию логина
header("Location: /");
exit;