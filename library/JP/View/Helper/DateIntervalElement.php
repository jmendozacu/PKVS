<?php

class JP_View_Helper_DateIntervalElement
    extends Zend_View_Helper_FormElement
{
    protected $html = '';
    protected $date_format="dateFormat: 'dd MM yy'";
    public function dateIntervalElement($name, $value = null, $attribs = null)
    {
        if (is_array($attribs))
        {
            $format = (isset($attribs['format'])) ? "dateFormat: '".$value['areanum']."'" : $this->date_format;
            $geonum = (isset($value['geonum'])) ? $value['geonum'] : '';
           // $localnum = (isset($value['localnum'])) ? $value['localnum'] : '';
        }
        $areanum = $geonum = $localnum = '';
        $script='$(function ()
{

    $("#txtStartDate, #txtEndDate").datepicker(
    {
        showOn: "both",
        beforeShow: customRange,
        dateFormat: "dd M yy",
        firstDay: 1,
        changeFirstDay: false
    });

});

function customRange(input)
{

    var min = null;
        var dateMin = min;
        var dateMax = null;
        var dayRange = 6;  // Set this to the range of days you want to restrict to


        if (input.id == "txtStartDate")
        {
            if ($("#txtEndDate").datepicker("getDate") != null)
            {
                dateMax = $("#txtEndDate").datepicker("getDate");
                dateMin = $("#txtEndDate").datepicker("getDate");
                dateMin.setDate(dateMin.getDate() - dayRange);
                if (dateMin < min)
                {
                        dateMin = min;
                }
             }
             else
             {
                //dateMax = new Date(); //Set this to your absolute maximum date
             }
        }
        else if (input.id == "txtEndDate")
        {
                dateMax = new Date(); //Set this to your absolute maximum date
                if ($("#txtStartDate").datepicker("getDate") != null)
                {
                        dateMin = $("#txtStartDate").datepicker("getDate");
                        var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate() + dayRange);

                        if(rangeMax < dateMax)
                        {
                            dateMax = rangeMax;
                        }
                }
        }
    return {
                minDate: dateMin,
                maxDate: dateMax,
            };

}';
        $this->view->headScript()->appendScript($script, $type = 'text/javascript', $attrs = array());
        //$this->view->headScript()->appendFile($this->view->baseUrl() . "/js/jquery-ui-1.7.2.custom.min.js");

        $helper = new Zend_View_Helper_FormText();
               // $helper = new ZendX_Jquery_View_Help();

        $helper->setView($this->view);

        if (is_array($value))
        {
            $areanum = (isset($value['areanum'])) ? $value['areanum'] : '';
            $geonum = (isset($value['geonum'])) ? $value['geonum'] : '';
           // $localnum = (isset($value['localnum'])) ? $value['localnum'] : '';
        }

        $this->html .= $helper->formText('txtStartDate',$areanum,array('class'=>'calendar'));
        $this->html .= $helper->formText('txtEndDate',$geonum,array('class'=>'calendar'));



        return $this->html;
    }

}

