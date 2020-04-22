# Форк модуля для drupal 8 - NEXT PREVIOUS POST BLOCK
---------------------------

Оригинал модуля: https://git.drupalcode.org/project/nextpre
Что добавлено по сравнению с оригинальным модулем:
- Теперь модуль генерирует контент темой "nextprev", а не програмно как раньше.
- Добавлены twig функции.

TWIG ФУНКЦИИ
-----------
getNextPrevById ( $nid, $ntype, $name_prev = "", $name_next = "" )
- $nid - Идентификатор node
- $ntype - Тип node
- $name_prev - Имя ссылки prev
- $name_next - Имя ссылки next

getNextById ( $nid, $ntype, $name = "" )
- $nid - Идентификатор node
- $ntype - Тип node
- $name - Имя ссылки

getPrevById ( $nid, $ntype, $name = "" )
- $nid - Идентификатор node
- $ntype - Тип node
- $name - Имя ссылки

INTRODUCTION
-----------
  Offering NEXT PREVIOUS POST BLOCK without going to the listing page.

REQUIREMENTS
------------
  The basic nextpre module has node dependencies, nothing special is required.

CONFIGURATION
-------------
  1. Install module “Next and previous link”.
  2. Go to the “Block Layout”. Eg:- Admin Menu >> structure >> block layout
  3. Go to the your block region.
  4. Click the "Place block" button and in the modal dialog click the 
     "Place block" button next to "Next Previous link".
  5. On the block configuration form you can choose the node bundle name to 
     filter and the next/previous labels the buttons will have.
