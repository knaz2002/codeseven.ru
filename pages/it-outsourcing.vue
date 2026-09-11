<template>
  <div class="it-outsourcing-page">
    <section class="it-outsourcing-hero" aria-labelledby="it-outsourcing-hero-title">
      <div class="it-outsourcing-hero__container">
        <div class="it-outsourcing-hero__row">
          <div class="it-outsourcing-hero__content">
            <h1 id="it-outsourcing-hero-title" class="it-outsourcing-hero__title">
              IT-аутсорсинг
            </h1>
            <p class="it-outsourcing-hero__lead">
              Мы предлагаем полное обслуживание, поддержку и модернизацию оборудования и систем, 
              сокращая расходы и обеспечивая бесперебойную работу ваших бизнес-процессов. 
            </p>
            <button type="button" class="it-outsourcing-hero__cta" @click="openItModal">
              Оставить заявку
              <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.2704 4.10258L15.4487 0L14.2703 1.26495L17.8221 5.07857L0 5.10541V6.89459L17.8721 6.86775L14.2695 10.7351L15.4478 12L19.2704 7.89742C19.7377 7.39333 20 6.71113 20 6C20 5.28887 19.7377 4.60667 19.2704 4.10258Z" fill="#141517"/>
              </svg>
            </button>

            <ul class="it-outsourcing-hero__features">
              <li class="it-outsourcing-hero-feature">
                <span class="it-outsourcing-hero-feature__icon" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <div class="it-outsourcing-hero-feature__body">
                  <p class="it-outsourcing-hero-feature__title">Значительная экономия</p>
                  <p class="it-outsourcing-hero-feature__text">
                    Сокращение затрат в 2-3 раза.
                  </p>
                </div>
              </li>
              <li class="it-outsourcing-hero-feature">
                <span class="it-outsourcing-hero-feature__icon" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <div class="it-outsourcing-hero-feature__body">
                  <p class="it-outsourcing-hero-feature__title">Скорость</p>
                  <p class="it-outsourcing-hero-feature__text">
                    Постоянный мониторинг и быстрые экстренные выезды специалистов.
                  </p>
                </div>
              </li>
              <li class="it-outsourcing-hero-feature">
                <span class="it-outsourcing-hero-feature__icon" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <div class="it-outsourcing-hero-feature__body">
                  <p class="it-outsourcing-hero-feature__title">Качество</p>
                  <p class="it-outsourcing-hero-feature__text">
                    Обеспечение бесперебойной работы всей IT-инфраструктуры.
                  </p>
                </div>
              </li>
            </ul>
          </div>
          <div class="it-outsourcing-hero__media">
            <img
              class="it-outsourcing-hero__figure"
              src="/img/outsourcing/hero-pic.png"
              alt="Иллюстрация к разделу IT-аутсорсинг"
            />
          </div>
        </div>
      </div>      
    </section>

    <section class="it-outsourcing-services" aria-labelledby="it-outsourcing-services-title">
      <div class="it-outsourcing-services__container">
        <header class="it-outsourcing-services__head">
          <h2 id="it-outsourcing-services-title" class="it-outsourcing-services__title">
            Что мы предлагаем?
          </h2>
          <p class="it-outsourcing-services__intro">
            IT-аутсорсинг — передача поддержки, обслуживания и модернизации IT-инфраструктуры сторонней компании.
          </p>
        </header>
        <ul class="it-outsourcing-services__grid">
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">
              Поддержка рабочих мест сотрудников
            </h3>
            <p class="it-outsourcing-service-card__text">
              Настройка ПК и периферии, учётные записи, типовые сбои и обращения в
              helpdesk.
            </p>
          </li>
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">Защита IT-систем</h3>
            <p class="it-outsourcing-service-card__text">
              Базовые меры информационной безопасности, политики доступа и контроль
              критичных точек.
            </p>
          </li>
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">
              Управление IT-инфраструктурой
            </h3>
            <p class="it-outsourcing-service-card__text">
              Учёт активов, изменения, мониторинг и единая точка ответственности за
              инфраструктуру.
            </p>
          </li>
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">
              Обслуживание серверов и сетей
            </h3>
            <p class="it-outsourcing-service-card__text">
              Администрирование серверов, обновления, сеть и связность между площадками.
            </p>
          </li>
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">
              Резервное копирование и архивирование данных
            </h3>
            <p class="it-outsourcing-service-card__text">
              Регулярные бэкапы, хранение и восстановление в согласованные сроки.
            </p>
          </li>
          <li class="it-outsourcing-service-card">
            <h3 class="it-outsourcing-service-card__title">
              Администрирование систем
            </h3>
            <p class="it-outsourcing-service-card__text">
              Сопровождение прикладных и системных сервисов под задачи вашего бизнеса.
            </p>
          </li>
        </ul>
      </div>  
    </section>

    <section class="it-outsourcing-workflow" aria-labelledby="it-outsourcing-workflow-title">
      <div class="it-outsourcing-workflow__container">        
        <div class="it-outsourcing-workflow__layout">
          <div class="it-outsourcing-workflow__visual">
            <h2 id="it-outsourcing-workflow-title" class="it-outsourcing-workflow__title">Как будем работать?</h2>
            <img
              class="it-outsourcing-workflow__idea"
              src="/img/outsourcing/workflow-pic.png"
              alt="Иллюстрация к этапам работы и инфраструктуре"
            />
          </div>
          <ol class="it-outsourcing-workflow__steps">
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">1</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Персональный менеджер
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  У вас есть личный менеджер, который всегда на связи и готов помочь.
                </p>
              </div>
            </li>
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">2</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Экстренная поддержка
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  При возникновении нештатных ситуаций мы быстро восстановим работу вашей компании.
                </p>
              </div>
            </li>
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">3</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Круглосуточная помощь
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  Наши специалисты готовы оказать поддержку 24/7 в любое время.
                </p>
              </div>
            </li>
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">4</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Ежемесячные отчеты
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  Каждый месяц предоставляем отчёты о проделанной работе и рекомендации по оптимизации.
                </p>
              </div>
            </li>
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">5</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Мгновенная реакция
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  Реакция на заявку — всего 10 минут, после чего мы приступаем к решению проблемы.
                </p>
              </div>
            </li>
            <li class="it-outsourcing-workflow-step">
              <span class="it-outsourcing-workflow-step__num" aria-hidden="true">6</span>
              <div class="it-outsourcing-workflow-step__body">
                <h3 class="it-outsourcing-workflow-step__title">
                  Гарантии качества
                </h3>
                <p class="it-outsourcing-workflow-step__text">
                  Несем полную ответственность за выполнение условий, прописанных в договоре SLA.
                </p>
              </div>
            </li>
          </ol>
        </div>
      </div>
    </section>

    <section class="it-outsourcing-pricing" aria-labelledby="it-outsourcing-pricing-title">
      <div class="it-outsourcing-pricing__container">
        <header class="it-outsourcing-pricing__head">
          <p class="it-outsourcing-pricing__label">Сервисы</p>
          <h2 id="it-outsourcing-pricing-title" class="it-outsourcing-pricing__title">Тарифы Code7</h2>
        </header>
        
        <div class="it-outsourcing-pricing__cards">
          <article class="it-outsourcing-pricing-card">
            <h3 class="it-outsourcing-pricing-card__name">Лайт</h3>
            <p class="it-outsourcing-pricing-card__subtitle">до 3-х серверов</p>
            <p class="it-outsourcing-pricing-card__subtitle">до 15 пользователей</p>
            <p class="it-outsourcing-pricing-card__price">от 25 000 ₽</p>
            <p class="it-outsourcing-pricing-card__lead">
              Если ваш бизнес развивается и расширяется, IT-аутсорсинг поможет вам:
            </p>
            <ul class="it-outsourcing-pricing-card__list">
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">выбрать оптимальное оборудование (экономия до 100%)</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">уладить вопросы с провайдерами и банками</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">установить нужное программное обеспечение</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">наладить рабочие места и проконсультировать по работе с софтами</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">внедрить и доработать системы</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">обеспечить безопасность данных</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">и многое другое</span>
              </li>
            </ul>
            <button type="button" class="it-outsourcing-pricing-card__button">
              Обсудить
            </button>
          </article>

          <article class="it-outsourcing-pricing-card">
            <h3 class="it-outsourcing-pricing-card__name">Стандарт</h3>
            <p class="it-outsourcing-pricing-card__subtitle">3-5 серверов</p>
            <p class="it-outsourcing-pricing-card__subtitle">до 50 пользователей</p>
            <p class="it-outsourcing-pricing-card__price">от 100 000 ₽</p>
            <p class="it-outsourcing-pricing-card__lead">
              Если вы уже наладили IT-инфраструктуру, то IT-аутсорсинг станет для вас полезен в следующих направлениях:
            </p>
            <ul class="it-outsourcing-pricing-card__list">
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">повышение эффективности бизнес-процессов</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">оптимизация хранения данных, ремонт оборудования</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">поддержка операционных систем и программ с устранением возможных сбоев</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">организация резервного копирования</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">и многое другое</span>
              </li>
            </ul>
            <button type="button" class="it-outsourcing-pricing-card__button">
              Обсудить
            </button>
          </article>

          <article class="it-outsourcing-pricing-card">
            <h3 class="it-outsourcing-pricing-card__name">Профи</h3>
            <p class="it-outsourcing-pricing-card__subtitle">до 10 серверов</p>
            <p class="it-outsourcing-pricing-card__subtitle">до 100 пользователей</p>
            <p class="it-outsourcing-pricing-card__price">от 250 000 ₽</p>
            <p class="it-outsourcing-pricing-card__lead">
              В крупных компаниях обычно уже сформирована значительная IT-инфраструктура, которая требует значительных затрат как на персонал, так и на оборудование. В таких случаях IT-аутсорсинг поможет:
            </p>
            <ul class="it-outsourcing-pricing-card__list">
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">снизить численность штатных сотрудников</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">уменьшить расходы организации</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">оптимизировать IT-процессы</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">четко регламентировать обязанности каждого сотрудника с учетом их прав</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">разработать мероприятия для повышения эффективности бизнеса</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">поддерживать все системы в рабочем состоянии</span>
              </li>
              <li class="it-outsourcing-pricing-card__item">
                <span class="it-outsourcing-pricing-card__check" aria-hidden="true">
                  <TheSvg type="check" />
                </span>
                <span class="it-outsourcing-pricing-card__text">и многое другое</span>
              </li>
            </ul>
            <button type="button" class="it-outsourcing-pricing-card__button">
              Обсудить
            </button>
          </article>
        </div>
      </div>
    </section>
    <PageFooter />
  </div>
</template>

<script setup lang="ts">
import TheSvg from "~/components/TheSvg.vue";
import PageFooter from "~/components/main/PageFooter.vue";
import { useModalStore } from "~/stores/modal";

const modalStore = useModalStore();

const openItModal = () => {
  modalStore.openModal("it");
};
</script>
