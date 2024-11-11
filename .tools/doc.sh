#!/usr/bin/env bash

doc() {
   printf "

   ------ Управление   ./tools/app.sh ------

   init               - инициализация нового проекта
   build              - построить контейнер
   up                 - запустить контейнер
   down               - остановить контейнер
   mc                 - создать миграцию
   ma                 - применить миграции
   queue              - запустить очередь
   fxt                - накатить фикстуры
   ent <options>      - создать сущность
   composer <options> - композер
   cli <options>      - консольные команды в контейнере
   exec <options>     - произвольные команды в контейнере

  ------ Тестирование  ./tools/test.sh ------

   fxt                - накатить фикстуры
   run                - запутить тесты



   "
}
