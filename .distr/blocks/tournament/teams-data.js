/**
 * Данные команд для турнирной таблицы
 * Этот файл содержит информацию о командах, их игроках и статистике
 */
const TEAMS_DATA = [
  {
    name: "Администрация",
    trophies: "🏆🏆",
    tournaments: 2,
    points: 6,
    photo: "img/team/admin2.webp",
    players: [
      {
        name: "pavelsolnsev",
        photo: "img/players/pavelsolnsev.png",
      },
      {
        name: "Gavrilovram",
        photo: "img/players/Gavrilov.png",
      },
      {
        name: "delay_kpacubo",
        photo: "img/players/kpacubo.png",
      },
      {
        name: "Perunov_Vladislav",
        photo: "img/players/Perunov_Vladislav.png",
      },
      {
        name: "dergaev94",
        photo: "img/players/dergaev.png",
      },
      {
        name: "filipps1",
        photo: "img/players/filipps1.png",
      },
      {
        name: "Иван",
        photo: "img/players/default.jpg",
      },
    ],
  },
  {
    name: "Леон",
    trophies: "⚪️",
    tournaments: 3,
    points: 4,
    photo: "img/team/leon.webp",
    players: [
      {
        name: "nikita_a1exandrovich",
        photo: "img/players/nikita.png",
      },
      {
        name: "Vadik_69_11",
        photo: "img/players/Vadik.png",
      },
      {
        name: "al11114",
        photo: "img/players/al11114.png",
      },
      {
        name: "toxa1392777",
        photo: "img/players/toxa1392777.png",
      },
      {
        name: "toshnotik666",
        photo: "img/players/toshnotik666.png",
      },
      {
        name: "vehrbrvk50",
        photo: "img/players/default.jpg",
      },
      {
        name: "alexdugar59",
        photo: "img/players/alexdugar59.png",
      },
      {
        name: "TimRamen",
        photo: "img/players/TimRamen.png",
      },
    ],
  },
  {
    name: "Ручеёк",
    trophies: "🏆",
    tournaments: 2,
    points: 3,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "Ислам Халиков",
        photo: "img/players/islam.png",
      },
      {
        name: "seivrtd",
        photo: "img/players/seivrtd.png",
      },
      {
        name: "Mirinian",
        photo: "img/players/mirinian.png",
      },
      {
        name: "AlexeiD2025",
        photo: "img/players/AlexeiD2025.png",
      },
      {
        name: "svyatoslavspirin",
        photo: "img/players/svyatoslavspirin.png",
      },
    ],
  },
  {
    name: "Брано",
    trophies: "⚪️",
    tournaments: 1,
    points: 2,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "filipps1",
        photo: "img/players/filipps1.png",
      },
      {
        name: "vl_l24",
        photo: "img/players/vl_l24.png",
      },
      {
        name: "Mirinian",
        photo: "img/players/mirinian.png",
      },
      {
        name: "SenyaAvgan",
        photo: "img/players/senyaAvgan.png",
      },
      {
        name: "mr_snak4",
        photo: "img/players/mr_snak4.png",
      },
    ],
  },
  {
    name: "Worlds",
    trophies: "⚪️",
    tournaments: 2,
    points: 2,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "Jorik",
        photo: "img/players/jorik.png",
      },
      {
        name: "evgeniyshvetsov",
        photo: "img/players/evgeniyshvetsov.png",
      },
      {
        name: "Дмитрий З",
        photo: "img/players/default.jpg",
      },
      {
        name: "ZhekaFootball",
        photo: "img/players/Evgenkozl.png",
        icon: "🟨",
      },
      {
        name: "Александр",
        photo: "img/players/aleksandr.png",
      },
      {
        name: "Даниил Турланов",
        photo: "img/players/tyrlanov.png",
      },
      {
        name: "Vyacheslav Batrakov",
        photo: "img/players/vacheslav.png",
      },
    ],
  },
  {
    name: "Вольт",
    trophies: "⚪️",
    tournaments: 1,
    points: 1,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "t1ma27",
        photo: "img/players/t1ma27.png",
      },
      {
        name: "y0ung_m0on",
        photo: "img/players/igor_oru.png",
      },
      {
        name: "Abdulatip44",
        photo: "img/players/Abdulatip44.png",
        icon: "🟨",
      },
      {
        name: "KroxaAn",
        photo: "img/players/kroxaAn.png",
      },
      {
        name: "deltaivan",
        photo: "img/players/deltaivan.png",
      },
    ],
  },
  {
    name: "Юность",
    trophies: "⚪️",
    tournaments: 1,
    points: 0,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "deltaivan",
        photo: "img/players/deltaivan.png",
      },
      {
        name: "Aleksey_AS_NR",
        photo: "img/players/Aleksey_AS_NR.png",
      },
      {
        name: "KroxaAn",
        photo: "img/players/kroxaAn.png",
      },
      {
        name: "Дмитрий Шмелев",
        photo: "img/players/shmel.png",
      },
      {
        name: "Vyacheslav Batrakov",
        photo: "img/players/vacheslav.png",
      },
    ],
  },
  {
    name: "Engelbert",
    trophies: "⚪️",
    tournaments: 0,
    points: 0,
    photo: "img/team/nologo.webp",
    players: [
      {
        name: "AlyevRuslan",
        photo: "img/players/CyJlTaH1117.png",
      },
      {
        name: "izi0895",
        photo: "img/players/izi0895.png",
      },
      {
        name: " IIpets",
        photo: "img/players/IIpets.png",
      },
      {
        name: "HA_3AKATE_KAPbEPbI",
        photo: "img/players/default.jpg",
      },
      {
        name: "GoshaSc",
        photo: "img/players/default.jpg",
      },
    ],
  },
];

