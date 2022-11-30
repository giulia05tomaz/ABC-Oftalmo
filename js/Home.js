$(document).ready(function () {
  $("#modalCenter").modal("show");
});

let navBtn = $(".navbar-links a");

var scrollToo = "";
let bannerSection = $("#carouselExampleIndicators");
let servicesSection = $("#services-area");
let aboutSection = $("#about-areaHome");
let contato = $(".contactArea");
let agendamento = $(".agendamento");

const mocksTimer = {
  0: ["00:00"],
  1: [
    "09:30",
    "10:00",
    "10:30",
    "11:00",
    "11:30",
    "13:30",
    "14:00",
    "14:30",
    "15:00",
    "15:30",
    "16:00",
    "16:30",
    "17:00",
    "17:30",
  ],
  2: ["13:30", "14:00", "14:30", "15:00", "15:30"],
  3: [
    "09:30",
    "10:00",
    "10:30",
    "11:00",
    "11:30",
    "13:30",
    "14:00",
    "14:30",
    "15:00",
    "15:30",
    "16:00",
    "16:30",
    "17:00",
    "17:30",
  ],
  4: ["13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"],
  5: ["13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30"],
  6: ["00:00"],
};
var videos = [1, 2, 3, 4, 5];

function pauseVideo(videoNum) {
  videos.forEach((item) => {
    var myVideo = document.getElementById(`video${item}`);
    if (item !== videoNum) {
      myVideo.pause();
    }
  });
}

const element1 = document.querySelector("#video1");
const element2 = document.querySelector("#video2");
const element3 = document.querySelector("#video3");
const element4 = document.querySelector("#video4");
const element5 = document.querySelector("#video5");



element1.addEventListener("playing", () => {

  pauseVideo(1);
});
element2.addEventListener("playing", () => {
  pauseVideo(2);
});
element3.addEventListener("playing", () => {
  pauseVideo(3);
});
element4.addEventListener("playing", () => {
  pauseVideo(4);
});
element5.addEventListener("playing", () => {
  pauseVideo(5);
});


$(navBtn).click(function () {
  let btnId = $(this).attr("id");

  if (btnId == "inicio") {
    scrollToo = bannerSection;
  } else if (btnId == "especialidades") {
    scrollToo = servicesSection;
  } else if (btnId == "sobre") {
    scrollToo = aboutSection;
  } else if (btnId == "contato") {
    scrollToo = contato;
  }

  $([document.documentElement, document.body]).animate(
    {
      scrollTop: scrollToo.offset().top - 100,
    },
    1000
  );
});

$(".carousel").carousel({
  interval: 5000,
});

$("#menuButton").click(() => {
  if ($("#linksContainer").css("display") == "none") {
    $("#linksContainer").css("display", "block");
  } else {
    $("#linksContainer").css("display", "none");
  }
});

var dateAtual = new Date();
var year = dateAtual.getFullYear();
var month =
  dateAtual.getMonth() < 10
    ? "0" + (dateAtual.getMonth() + 1)
    : dateAtual.getMonth() + 1;
var day =
  dateAtual.getDate() < 10 ? "0" + dateAtual.getDate() : dateAtual.getDate();
$("#dataAgenda").attr("min");
$('input[type="date"]').attr("min", year + "-" + month + "-" + day);
$('input[type="date"]').attr("max", year + 1 + "-" + month + "-" + day);

const mockProcedimentos = [
  {
    descr: "Campimetria",
  },
  {
    descr: "Curva Tensional Diária",
  },
  {
    descr: "Mapeamento de Retina",
  },
  {
    descr: "Paquimetria",
  },
  {
    descr: "Retinografia",
  },
  {
    descr: "Teste Ortóptico",
  },
  {
    descr: "Teste de Teller",
  },
  {
    descr: "Tonometria",
  },
  {
    descr: "Topografia de Córnea",
  },
  {
    descr: "Acuidade visual (PAM)",
  },
  {
    descr: "Teste de adaptação de Lentes",
  },
  {
    descr: " Microscopia Especular da Cornea",
  },
];

function listaprocedimentos() {
  var options = [];

  mockProcedimentos.map((item, index) => {
    options.push(
      '<option class = "text-dark"  type="checkbox" value="' +
        item.descr +
        '">' +
        item.descr +
        "</option>"
    );
  });
  $(".bs-placeholder").addClass("disabled");
  $("#cmbStatus").append(options.join("")).selectpicker("refresh");
}

function gravaAgendamento() {
  var jsonEnvio = {
    nomeuser: $("#nameAgendamento").val(),
    telUser: $("#telAgenda").val(),
    emailPaciente: $("#emailAgenda").val(),
    dataAgendamento: $("#dataAgenda").val(),
    hrAgendamento: $("#timer").val(),
    observacaoAgenda:
      "Procedimentos: " +
      $("#cmbStatus").val().toString() +
      "Observações do paciente:" +
      $("#message").val(),
    confirma: $("#confirmAgenda").is(":checked") ? "SIM" : "",
  };
  var valid = false;
  $.each(jsonEnvio, function (item, value) {
    if (!value || value == " " || value == "") {
      valid = true;
      return false;
    }
  });

  if (valid) {
    $("#tpModal").addClass("modal-warning");
    $("#btTpModal").addClass("btn-outline-warning");
    $("#messageModal").text("Por favor preencha todos os campos");
    $("#modalMessage").modal("show");
    return;
  }
  $.ajax({
    type: "POST",
    url: `./Painel/web_services/ws-site.php/gravaAgendamentoOnline`,
    data: JSON.stringify(jsonEnvio),
    success: function (response) {
      if (response == "invalid") {
        $("#tpModal").addClass("modal-warning");
        $("#btTpModal").addClass("btn-outline-warning");
        $("#messageModal").text("Horário não disponível para agendamento");
        $("#modalMessage").modal("show");
        return;
      }

      $("#tpModal").addClass("modal-success");
      $("#btTpModal").addClass("btn-outline-success");
      $("#messageModal").text(
        "A equipe entrará em contato para confirmar o agendamento"
      );
      $("#modalMessage").modal("show");
      $("input").val("");
      $(".selectpicker").selectpicker("deselectAll");
      $(".checkboxList").prop("checked", false);
      return;
    },
  });
}

listaprocedimentos();

function listTimer(datePass) {
  $("#timer").attr("disabled", false);
  $("#timer").html("");
  $("#timer").append(`
	<option value=""></option>
	`);
  mocksTimer[datePass].map((item) => {
    $("#timer").append(`
		<option value="${item}">${item}</option>
		`);
  });
}

$("#pedidoExams").on("click", function () {
  if ($(this).is(":checked")) {
    $("#cmbStatus").attr("disabled", false);
    $("#cmbStatus").selectpicker("refresh");
  } else {
    $("#cmbStatus").attr("disabled", true);
    $("#cmbStatus").selectpicker("refresh");
  }
});

$("#telAgenda").mask("(00)00000-0000");

function diffDays(date1) {
  try {
    var dateAtual = new Date().toISOString().split("T")[0].split("-");
    var date2 = new Date(date1).toISOString().split("T")[0].split("-");

    console.log({ dateAtual, date2 });
    if (Number(date2[0]) >= Number(dateAtual[0])) {
      if (Number(date2[1]) == Number(dateAtual[1])) {
        if (Number(date2[2]) >= Number(dateAtual[2])) {
          return true;
        }
        return false;
      } else if (Number(date2[1]) > Number(dateAtual[1])) {
        return true;
      }
    }
    return false;
  } catch (error) {
    console.log("error date");
  }
}

$("#dataAgenda").on("change", function () {
  var dateValue = new Date($(this).val());
  var newDate = new Date(dateValue.setDate(dateValue.getDate() + 1));
  if (newDate.getDay() == 6 || newDate.getDay() == 0) {
    $("#dateHelper").text(
      "Atenção, data indisponível para agendamento de consulta"
    );
    $("#timer").attr("disabled", true);
    return;
  } else {
    $("#dateHelper").text("");
  }
  diffDays($(this).val())
    ? listTimer(newDate.getDay())
    : $("#timer").attr("disabled", true);
});
