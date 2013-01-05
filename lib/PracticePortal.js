var PortalState = new Object();
var fullwidth = $('.PracticePortal').innerWidth();
var largewidth = $('.introduction').outerWidth();
var medwidth = $('.questionContent').outerWidth()+$('.questionContentClose').outerWidth();

function SavePortalState() {
    $.cookie('PatientPortalState', JSON.stringify(PortalState));
}

function displayQuestions($locationSelector) {
    $idquestions = $locationSelector.data('idquestions');
    $('.locationQuestions').fadeOut(function() {
        $.each($idquestions, function(i, item) {
            $('.questionSelector').each(function() {
                $idquestion = $(this).data('idquestions');
                if($idquestion == item) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        $(this).fadeIn();
    })
    $('.introduction').animate({left: -largewidth,right:largewidth});
    $('.treatmentMan').animate({right: largewidth});
    $('.locationQuestions').animate({left:0,right:0});
    PortalState.idlocations = $locationSelector.data('idlocations');
    SavePortalState();
}
function hideQuestions() {
    $('.introduction').animate({left:0,right:0});
    $('.treatmentMan').animate({right:0});
    $('.locationQuestions').animate({left:fullwidth,right:-fullwidth});
    delete PortalState.idlocations;
    SavePortalState();
}
function displayQuestionContent(idquestions) {
    $('.questionContent[data-idquestions="'+idquestions+'"]').animate({right:0});
    PortalState.idquestions = idquestions;
    SavePortalState();
}
function hideQuestionContent() {
    $('.questionContent').animate({right:-medwidth});
    delete PortalState.idquestions;
    SavePortalState();
}
function displayConditionList() {
    $('.conditionList').fadeIn();
    PortalState.conditionknown = true;
    SavePortalState();
}
function hideConditionList() {
    $('.conditionList').fadeOut();
    delete PortalState.conditionknown;
    SavePortalState();
}
function displayCondition(idconditions) {
    $condition = $('.condition[data-idconditions="'+idconditions+'"]');
    $condition.fadeIn();
    $condition.find('img, iframe').each(function(i) {
        $(this).attr('src', $(this).data('src'));
    });
    PortalState.idconditions = idconditions;
    SavePortalState();
}
function hideCondition(){
    $('.condition').fadeOut();
    delete PortalState.idconditions;
    SavePortalState();
}
function displayPractitioner(idpractitioners) {
    $('.practitioner[data-idpractitioners="'+idpractitioners+'"]').fadeIn();
    PortalState.idpractitioners = idpractitioners;
    SavePortalState();
}
function hidePractitioner(){
    $('.practitioner').fadeOut();
    delete PortalState.practitioners;
    SavePortalState();
}

$(document).ready(function() {
    // Preload the videos
    
    
    PortalState = $.cookie('PatientPortalState') ? JSON.parse($.cookie('PatientPortalState')) : new Object();
    // 1s after loading, check which route they took and load the page they where on.
    setTimeout(function() {
        if(PortalState.idlocations) {
            displayQuestions($('.locationSelector[data-idlocations="'+PortalState.idlocations+'"]'));
            setTimeout(function() { 
                if(PortalState.idquestions) {
                displayQuestionContent(PortalState.idquestions);
                setTimeout(function() {
                    if(PortalState.idconditions) {
                        displayCondition(PortalState.idconditions);
                        setTimeout(function() {
                            if(PortalState.idpractitioners) {
                                displayPractitioner(PortalState.idpractitioners);
                            }
                        },1000);
                    }
                },1000);
                }
            },500);
        } else if(PortalState.conditionknown) {
            displayConditionList();
            setTimeout(function() {
                if(PortalState.idconditions) {
                    displayCondition(PortalState.idconditions);
                    setTimeout(function() {
                        if(PortalState.idpractitioners) {
                            displayPractitioner(PortalState.idpractitioners);
                        }
                    },1000);
                }
            }, 1000);
        }
    },1000);
    $('.conditionknown').click(function() {
        displayConditionList();
    });
    $('.conditionListCancel').click(function() {
        hideConditionList();
    });
    $('.locationSelector').click(function() {
        hideQuestionContent();
        displayQuestions($(this));
    });
    $('.locationQuestionsCancel').click(function() {
        hideQuestions();
    });
    $('.questionSelector').click(function() {
        displayQuestionContent($(this).data('idquestions'));
    });
    $('.questionContentClose').click(function() {
        hideQuestionContent();
    });
    $('.conditionOption').click(function() {
        displayCondition($(this).data('idconditions'));
    });
    $('.conditionCancel').click(function() {
        hideCondition();
    });
    $('.practitionerOption').click(function() {
        displayPractitioner($(this).data('idpractitioners'));
    });
    $('.practitionerCancel').click(function() {
        hidePractitioner();
    });
});