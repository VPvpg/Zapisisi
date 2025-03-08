<?php
// PHP для работы с файлом
// Путь к notes.md в текущей папке
$file = __DIR__ . '/notes.md'; 

// Если форма отправлена, сохраняем текст
if ($_POST['content']) {
    file_put_contents($file, $_POST['content']);
}

// Читаем файл или задаём начальный текст
$content = file_exists($file) ? file_get_contents($file) : '# Заметки';
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Кодировка для русских букв -->
    <meta charset="UTF-8">
    <!-- Заголовок -->
    <title>Заметки</title>
    <!-- Мета-тег для правильного масштабирования на телефоне -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Стили только для телефона -->
    <style>
        /* Вся страница */
        body { 
            margin: 0; /* Без внешних отступов */
            padding: 0; /* Без внутренних отступов */
            font-family: sans-serif; /* Шрифт */
            overflow-x: hidden; /* Без горизонтальной прокрутки */
            overflow-y: auto; /* Вертикальная прокрутка */
            width: 100vw; /* Ширина на весь экран */
            box-sizing: border-box; /* Учитываем всё в размерах */
        }
        /* Поле ввода текста */
        textarea { 
            width: 100%; /* Ширина на весь экран */
            height: 60vh; /* Высота 60% экрана */
            font-size: 22px; /* Шрифт покрупнее */
            padding: 10px; /* Минимальный отступ */
            margin: 0; /* Без внешних отступов */
            border: none; /* Без рамки */
            box-sizing: border-box; /* Учитываем padding */
            overflow-y: auto; /* Вертикальная прокрутка */
            overflow-x: hidden; /* Без горизонтальной прокрутки */
        }
        /* Ползунок */
        textarea::-webkit-scrollbar { 
            width: 20px; /* Толщина ползунка */
        }
        textarea::-webkit-scrollbar-thumb { 
            background: #666; /* Цвет ползунка */
            border-radius: 10px; /* Закругление */
        }
        /* Контейнер для кнопки и индикатора */
        .button-container { 
            width: 100%; /* Ширина на весь экран */
            margin: 0; /* Без отступов */
            padding: 0; /* Без внутренних отступов */
            display: flex; /* Элементы внутри */
            flex-direction: column; /* Друг под другом */
            align-items: stretch; /* Растягиваем на всю ширину */
        }
        /* Кнопка */
        button { 
            width: 100%; /* Ширина на весь экран */
            font-size: 24px; /* Крупный текст */
            padding: 15px; /* Отступы внутри */
            margin: 0; /* Без внешних отступов */
            border: none; /* Без рамки */
            background: #ddd; /* Лёгкий фон */
        }
        /* Индикатор */
        #save-indicator { 
            width: 100%; /* Ширина на весь экран */
            font-size: 18px; /* Крупный текст */
            color: gray; /* Начальный цвет */
            text-align: center; /* По центру */
            padding: 5px; /* Минимальный отступ */
            margin: 0; /* Без внешних отступов */
        }
        /* Превью */
        #preview { 
            width: 100%; /* Ширина на весь экран */
            font-size: 22px; /* Шрифт */
            padding: 10px; /* Минимальный отступ */
            margin: 2px; /* Без внешних отступов */
        }
    </style>
    <!-- Marked.js для Markdown -->
    <script src="marked.min.js"></script>
</head>
<body>
    <!-- Форма -->
    <form method="POST">
        <!-- Поле ввода -->
        <textarea id="editor" name="content"><?php echo htmlspecialchars($content); ?></textarea>
        <!-- Контейнер -->
        <div class="button-container">
            <!-- Кнопка -->
            <button type="submit">Сохранить</button>
            <!-- Индикатор -->
            <span id="save-indicator">Сохранено!</span>
        </div>
    </form>
    <!-- Превью -->
    <div id="preview"></div>
    <!-- JavaScript -->
    <script>
        // Находим элементы
        let editor = document.getElementById('editor');
        let preview = document.getElementById('preview');
        let saveIndicator = document.getElementById('save-indicator');
        let form = document.querySelector('form');
        let lastSavedContent = editor.value;

        // Обновляем превью
        function updatePreview() {
            preview.innerHTML = marked.parse(editor.value);
        }

        // При вводе текста
        editor.oninput = function() {
            updatePreview();
            if (editor.value !== lastSavedContent) {
                saveIndicator.textContent = 'Не сохранено';
                saveIndicator.style.color = 'red';
            }
        };

        // При отправке формы
        form.onsubmit = function() {
            saveIndicator.textContent = 'Сохранено!';
            saveIndicator.style.color = 'green';
            lastSavedContent = editor.value;
            return true;
        };

        // Старт превью
        updatePreview();
    </script>
</body>
</html>