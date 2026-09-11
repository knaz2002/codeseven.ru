<template>
  <Transition name="modal-appear" :duration="{ enter: 350, leave: 0 }">
    <div
      v-if="modalStore.activeModal === 'it'"
      class="modal modal-it modal-service"
    >
      <div class="modal__overlay" @click="closeModal"></div>
      <div class="modal__wrap" data-simplebar>
        <div class="modal__content modal-service__content">
          <button
            class="modal__close"
            @click="closeModal"
            aria-label="Закрыть"
          ></button>
          <div class="modal-service__head">
            <div class="modal-service__ico ico-anim">
              <img src="/public/img/modal/it.svg" alt="ico" />
            </div>
            <h2 class="modal-service__title tite">IT-outsource</h2>
          </div>
          <div class="modal-service__body">
            <div class="modal-service__desktop">
              <div class="modal-service__block">
                <span class="modal-service__tag">Этапы работы: </span>
                <div class="modal-service__list">
                  <ol>
                    <li v-for="(item, i) in listItem" :key="i">
                      <p>{{ item.title }}</p>
                      <ul class="modal-service__list-sublist">
                        <li v-for="(itm, idx) in item.list" :key="idx">
                          {{ itm }}>
                        </li>
                      </ul>
                    </li>
                  </ol>
                </div>
              </div>
            </div>
            <div class="modal-service__mobile">
              <p class="modal-service__text">
                Комплексное обслуживание информационных систем и технической
                инфраструктуры компании по договору.
              </p>
            </div>
          </div>
          <div class="modal-service__footer">
            <button class="btn btn-dark" @click="openCallModal">
              Узнать больше
              <TheSvg type="arrow-r" />
            </button>
            <span class="modal-service__logo modal-service__desktop">
              <TheSvg type="logo" />
            </span>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { useModalStore } from "~/stores/modal";
import TheSvg from "../TheSvg.vue";

const modalStore = useModalStore();

const listItem = [
  {
    title: "Определение потребностей",
    list: [
      "Определяем, какие задачи вы передать на аутсорсинг: разработка, тестирование, поддержка, сопровождение и т. д.",
      "Формулируем цели: снижение затрат, ускорение проекта, доступ к экспертизе и т. п.",
      "Выбираем тип сотрудничества: полный аутсорсинг IT-отдела или выполнение конкретных задач.",
    ],
  },
  {
    title: "Составление технического задания (ТЗ)",
    list: [
      "Подготавливаем детальное описание задач, требований, сроков, ожидаемых результатов.",
      "Указываем используемые технологии, интеграции, масштаб проекта и уровень поддержки.",
    ],
  },
  {
    title: "Оценка стоимости и условий сотрудничества",
    list: [
      "Выбираем модель оплаты: фиксированная цена, почасовая ставка, месячная подписка.",
      "Прописываем условия SLA (уровень сервиса), NDA (неразглашение информации), порядок расторжения договора.",
    ],
  },
  {
    title: "Юридическое оформление",
    list: [
      "Проработка версий для разных устройств Подписание договора, где четко прописаны обязанности сторон, сроки, ответственность, конфиденциальность.",
      "Регулируем вопросы интеллектуальной собственности (IP).",
    ],
  },
  {
    title: "Интеграция и запуск сотрудничества",
    list: [
      "Внедрение команды аутсорсера в ваши бизнес-процессы.",
      "Наладка коммуникации, выбор инструментов (Jira, Slack, Trello и т. д.).",
      "Первые этапы реализации проекта, тестирование взаимодействия.",
    ],
  },
  {
    title: "Мониторинг и контроль эффективности",
    list: [
      "Регулярное отслеживание качества выполнения работ.",
      "Проведение регулярных встреч, отчетов, анализа KPI.",
      "При необходимости — корректировка условий сотрудничества.",
    ],
  },
];
const closeModal = () => {
  modalStore.closeModal();
};

const openCallModal = () => {
  modalStore.closeModal();
  modalStore.openModal("call");
};
</script>
