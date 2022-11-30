const page = localStorage.getItem("page");
const typeOfExams = {
  CIRURGIAS: "./images/Carrosel3.jpeg",
  EXAMES: "./images/exames.jpg",
  PROCEDIMENTOS: "./images/Carrosel3.jpeg",
};

function validPage() {
  if (window.location.pathname.includes("Oftalmologia")) {
    $("#linksContainer").remove();
  }
}

validPage();

const optionsChooser = (buttonActivate, listType) => {
  if (buttonActivate == "examButton") {
    $("#about-area").css({ "background-image": 'url("./images/exames.jpg")' });
    $(".image-teste").attr("src", "./images/exames.jpg");

  
  } else if (buttonActivate == "surgeries") {
    $("#about-area").css({
      "background-image": 'url("./images/Carrosel3.jpeg")',
      transition: "all 2s ease 0s;",
    });
    $(".image-teste").attr("src", "./images/Carrosel3.jpeg");
  
  } else {
    $(".image-teste").attr("src", "./images/Carrosel3.jpeg");
    $("#about-area").css({
      "background-image": 'url("./images/Carrosel3.jpeg")',
      transition: "all 2s ease 0s;",
    });

  }

  const allButons = $(".btnOftalmo");
  const selectedButton = $(`#${buttonActivate}`);
  allButons.removeClass("active");
  allButons.prop("disabled", false);
  selectedButton.addClass("active");
  selectedButton.prop("disabled", true);
  initialFuntion(buttonActivate, listType);
};

const initialFuntion = (buttonActivate, listType = "exams") => {
  const optionListId = $("#optionsSource");
  const contentListId = $("#contentSource");

  optionListId.html("");
  contentListId.html("");

  if (!buttonActivate) {
    $("#examButton").addClass("active");
    $("#examButton").prop("disabled", true);
  }

  const listTypes = {
    exams: exams,
    surgeries: surgeries,
    procedimentos: procedimentosMock,
  };

  listTypes[listType].map((item, index) => {
    optionListId.append(
      `<a onclick="changeTitle('${item.name}','${
        item.banner
      }')" class="nav-link ${
        index === 0 ? "active " : ""
      }" id="v-pills-home-${index}" data-toggle="pill" href="#v-pills-${index}" role="tab" aria-controls="v-pills-${index}" aria-selected="true">
                ${item.name}
            </a>`
    );
    contentListId.append(
      `<div class="tab-pane fade show  ${
        index === 0 ? "active " : ""
      }"  id="v-pills-${index}" role="tabpanel" aria-labelledby="v-pills-home-${index}">
			
			<div  class =" classImag">
			<img src="${item.url}" alt="Abcimag" width="150" height="150">
			</div>
			<div class ="divClass">
			${item.text}
			</div>
			</div>`
    );
  });
  const getType =
  document.getElementsByClassName("btnOftalmo active")[0].innerText;

  const bannerImage = listTypes[listType][0].banner
  console.log('get',getType)
   $("#titleHeader").text(listTypes[listType][0].name);
    $(".image-teste").attr("src",  bannerImage == undefined || bannerImage == "" ? typeOfExams[getType] : bannerImage);
};

initialFuntion();



function changeTitle(item, banner) {
  const getType =
    document.getElementsByClassName("btnOftalmo active")[0].innerText;

  $("#about-area").css({
    "background-image": `url(${
      banner == undefined || banner == "" ? typeOfExams[getType] : banner
    })`,
  });
  $(".image-teste").attr(
    "src",
    banner == undefined || banner == "" ? typeOfExams[getType] : banner
  );
  // console.log(banner)
  $("#titleHeader").text(item);
}

function selectButton() {
  if (page == "exames") {
    optionsChooser("examButton", "exams");

    // $("#titleHeader").text("Aberrometria (OPD Scan III)");
    // $(".image-teste").attr("src", "./images/Fotos/157.jpg");
    return;
  } else if (page == "procedimentos") {

    // $("#titleHeader").text("Capsulotomia (Yag laser)");
    optionsChooser("procedButton", "procedimentos");
    // $(".image-teste").attr("src", "./images/Carrosel3.jpeg");
    return;
  }
  // $(".image-teste").attr("src", "./images/exames.jpg");

  // $("#titleHeader").text("Anel Intraestromal (Tratamento para Ceratocone)");
  optionsChooser("surgeriesButton", "surgeries");
}

selectButton();
