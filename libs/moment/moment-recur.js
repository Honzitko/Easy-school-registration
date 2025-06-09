(function(root,factory){if(typeof exports==='object'){module.exports=factory(require('moment'))}else if(typeof define==='function'&&define.amd){define('moment-recur',['moment'],factory)}else{root.moment=factory(root.moment)}}(this,function(moment){var hasModule;hasModule=(typeof module!=="undefined"&&module!==null)&&(module.exports!=null);if(typeof moment==='undefined'){throw Error("Can't find moment")}
    var Interval=(function(){function createInterval(units,measure){for(var unit in units){if(units.hasOwnProperty(unit)){if(parseInt(unit,10)<=0){throw Error('Intervals must be greater than zero')}}}
        return{measure:measure.toLowerCase(),units:units}}
        function matchInterval(type,units,start,date){var diff=null;if(date.isBefore(start)){diff=start.diff(date,type,!0)}else{diff=date.diff(start,type,!0)}
            if(type=='days'){diff=parseInt(diff)}
            for(var unit in units){if(units.hasOwnProperty(unit)){unit=parseInt(unit,10);if((diff%unit)===0){return!0}}}
            return!1}
        return{create:createInterval,match:matchInterval}})();var Calendar=(function(){var unitTypes={"daysOfMonth":"date","daysOfWeek":"day","weeksOfMonth":"monthWeek","weeksOfMonthByDay":"monthWeekByDay","weeksOfYear":"week","monthsOfYear":"month"};var ranges={"daysOfMonth":{low:1,high:31},"daysOfWeek":{low:0,high:6},"weeksOfMonth":{low:0,high:4},"weeksOfMonthByDay":{low:0,high:4},"weeksOfYear":{low:0,high:52},"monthsOfYear":{low:0,high:11}};function checkRange(low,high,list){list.forEach(function(v){if(v<low||v>high){throw Error('Value should be in range '+low+' to '+high)}})}
        function namesToNumbers(list,nameType){var unit,unitInt,unitNum;var newList={};for(unit in list){if(list.hasOwnProperty(unit)){unitInt=parseInt(unit,10);if(isNaN(unitInt)){unitInt=unit}
            unitNum=moment().set(nameType,unitInt).get(nameType);newList[unitNum]=list[unit]}}
            return newList}
        function createCalendarRule(list,measure){var keys=[];if(measure==="daysOfWeek"){list=namesToNumbers(list,"days")}
            if(measure==="monthsOfYear"){list=namesToNumbers(list,"months")}
            for(var key in list)if(hasOwnProperty.call(list,key))keys.push(key);checkRange(ranges[measure].low,ranges[measure].high,keys);return{measure:measure,units:list}}
        function matchCalendarRule(measure,list,date){var unitType=unitTypes[measure];var unit=date[unitType]();if(list[unit]){return!0}
            if(unitType==='date'&&unit==date.add(1,'months').date(0).format('D')&&unit<31){while(unit<=31){if(list[unit]){return!0}
                unit++}}
            return!1}
        return{create:createCalendarRule,match:matchCalendarRule}})();var Recur=(function(){var ruleTypes={"days":"interval","weeks":"interval","months":"interval","years":"interval","daysOfWeek":"calendar","daysOfMonth":"calendar","weeksOfMonth":"calendar","weeksOfMonthByDay":"calendar","weeksOfYear":"calendar","monthsOfYear":"calendar"};var measures={"days":"day","weeks":"week","months":"month","years":"year","daysOfWeek":"dayOfWeek","daysOfMonth":"dayOfMonth","weeksOfMonth":"weekOfMonth","weeksOfMonthByDay":"weekOfMonthByDay","weeksOfYear":"weekOfYear","monthsOfYear":"monthOfYear"};function trigger(){var rule;var ruleType=ruleTypes[this.measure];if(!(this instanceof Recur)){throw Error("Private method trigger() was called directly or not called as instance of Recur!")}
        if((typeof this.units==="undefined"||this.units===null)||!this.measure){return this}
        if(ruleType!=="calendar"&&ruleType!=="interval"){throw Error("Invalid measure provided: "+this.measure)}
        if(ruleType==="interval"){if(!this.start){throw Error("Must have a start date set to set an interval!")}
            rule=Interval.create(this.units,this.measure)}
        if(ruleType==="calendar"){rule=Calendar.create(this.units,this.measure)}
        this.units=null;this.measure=null;if(rule.measure==='weeksOfMonthByDay'&&!this.hasRule('daysOfWeek')){throw Error("weeksOfMonthByDay must be combined with daysOfWeek")}
        for(var i=0;i<this.rules.length;i++){if(this.rules[i].measure===rule.measure){this.rules.splice(i,1)}}
        this.rules.push(rule);return this}
        function getOccurrences(num,format,type){var currentDate,date;var dates=[];if(!(this instanceof Recur)){throw Error("Private method trigger() was called directly or not called as instance of Recur!")}
            if(!this.start&&!this.from){throw Error("Cannot get occurrences without start or from date.")}
            if(type==="all"&&!this.end){throw Error("Cannot get all occurrences without an end date.")}
            if(!!this.end&&(this.start>this.end)){throw Error("Start date cannot be later than end date.")}
            if(type!=="all"&&!(num>0)){return dates}
            currentDate=(this.from||this.start).clone();if(type==="all"){if(this.matches(currentDate,!1)){date=format?currentDate.format(format):currentDate.clone();dates.push(date)}}
            while(dates.length<(num===null?dates.length+1:num)){if(type==="next"||type==="all"){currentDate.add(1,"day")}else{currentDate.subtract(1,"day")}
                if(this.matches(currentDate,(type==="all"?false:!0))){date=format?currentDate.format(format):currentDate.clone();dates.push(date)}
                if(type==="all"&&currentDate>=this.end){break}}
            return dates}
        function inRange(start,end,date){if(start&&date.isBefore(start)){return!1}
            if(end&&date.isAfter(end)){return!1}
            return!0}
        function unitsToObject(units){var list={};if(Object.prototype.toString.call(units)=='[object Array]'){units.forEach(function(v){list[v]=!0})}else if(units===Object(units)){list=units}else if((Object.prototype.toString.call(units)=='[object Number]')||(Object.prototype.toString.call(units)=='[object String]')){list[units]=!0}else{throw Error("Provide an array, object, string or number when passing units!")}
            return list}
        function isException(exceptions,date){for(var i=0,len=exceptions.length;i<len;i++){if(moment(exceptions[i]).isSame(date)){return!0}}
            return!1}
        function pluralize(measure){switch(measure){case "day":return"days";case "week":return"weeks";case "month":return"months";case "year":return"years";case "dayOfWeek":return"daysOfWeek";case "dayOfMonth":return"daysOfMonth";case "weekOfMonth":return"weeksOfMonth";case "weekOfMonthByDay":return"weeksOfMonthByDay";case "weekOfYear":return"weeksOfYear";case "monthOfYear":return"monthsOfYear";default:return measure}}
        function matchAllRules(rules,date,start){var i,len,rule,type;for(i=0,len=rules.length;i<len;i++){rule=rules[i];type=ruleTypes[rule.measure];if(type==="interval"){if(!Interval.match(rule.measure,rule.units,start,date)){return!1}}else if(type==="calendar"){if(!Calendar.match(rule.measure,rule.units,date)){return!1}}else{return!1}}
            return!0}
        function createMeasure(measure){return function(units){this.every.call(this,units,measure);return this}}
        var Recur=function(options){if(options.start){this.start=moment(options.start).dateOnly()}
            if(options.end){this.end=moment(options.end).dateOnly()}
            this.rules=options.rules||[];var exceptions=options.exceptions||[];this.exceptions=[];for(var i=0;i<exceptions.length;i++){this.except(exceptions[i])}
            this.units=null;this.measure=null;this.from=null;return this};Recur.prototype.startDate=function(date){if(date===null){this.start=null;return this}
            if(date){this.start=moment(date).dateOnly();return this}
            return this.start};Recur.prototype.endDate=function(date){if(date===null){this.end=null;return this}
            if(date){this.end=moment(date).dateOnly();return this}
            return this.end};Recur.prototype.fromDate=function(date){if(date===null){this.from=null;return this}
            if(date){this.from=moment(date).dateOnly();return this}
            return this.from};Recur.prototype.save=function(){var data={};if(this.start&&moment(this.start).isValid()){data.start=this.start.format("L")}
            if(this.end&&moment(this.end).isValid()){data.end=this.end.format("L")}
            data.exceptions=[];for(var i=0,len=this.exceptions.length;i<len;i++){data.exceptions.push(this.exceptions[i].format("L"))}
            data.rules=this.rules;return data};Recur.prototype.repeats=function(){if(this.rules.length>0){return!0}
            return!1};Recur.prototype.every=function(units,measure){if((typeof units!=="undefined")&&(units!==null)){this.units=unitsToObject(units)}
            if((typeof measure!=="undefined")&&(measure!==null)){this.measure=pluralize(measure)}
            return trigger.call(this)};Recur.prototype.except=function(date){date=moment(date).dateOnly();this.exceptions.push(date);return this};Recur.prototype.forget=function(dateOrRule){var i,len;var whatMoment=moment(dateOrRule);if(whatMoment.isValid()){whatMoment=whatMoment.dateOnly();for(i=0,len=this.exceptions.length;i<len;i++){if(whatMoment.isSame(this.exceptions[i])){this.exceptions.splice(i,1);return this}}
            return this}
            for(i=0,len=this.rules.length;i<len;i++){if(this.rules[i].measure===pluralize(dateOrRule)){this.rules.splice(i,1)}}};Recur.prototype.hasRule=function(measure){var i,len;for(i=0,len=this.rules.length;i<len;i++){if(this.rules[i].measure===pluralize(measure)){return!0}}
            return!1};Recur.prototype.matches=function(dateToMatch,ignoreStartEnd){var date=moment(dateToMatch).dateOnly();if(!date.isValid()){throw Error("Invalid date supplied to match method: "+dateToMatch)}
            if(!ignoreStartEnd&&!inRange(this.start,this.end,date)){return!1}
            if(isException(this.exceptions,date)){return!1}
            if(!matchAllRules(this.rules,date,this.start)){return!1}
            return!0};Recur.prototype.next=function(num,format){return getOccurrences.call(this,num,format,"next")};Recur.prototype.previous=function(num,format){return getOccurrences.call(this,num,format,"previous")};Recur.prototype.all=function(format){return getOccurrences.call(this,null,format,"all")};for(var measure in measures){if(ruleTypes.hasOwnProperty(measure)){Recur.prototype[measure]=Recur.prototype[measures[measure]]=createMeasure(measure)}}
        return Recur}());moment.recur=function(start,end){if(start===Object(start)&&!moment.isMoment(start)){return new Recur(start)}
        return new Recur({start:start,end:end})};moment.fn.recur=function(start,end){if(start===Object(start)&&!moment.isMoment(start)){if(typeof start.start==='undefined'){start.start=this}
        return new Recur(start)}
        if(!end){end=start;start=undefined}
        if(!start){start=this}
        return new Recur({start:start,end:end,moment:this})};moment.fn.monthWeek=function(){var week0=this.clone().startOf("month").startOf("week");var day0=this.clone().startOf("week");return day0.diff(week0,"weeks")};moment.fn.monthWeekByDay=function(date){return Math.floor((this.date()-1)/7)};moment.fn.dateOnly=function(){if(this.tz&&typeof(moment.tz)=='function'){return moment.tz(this.format('YYYY-MM-DDT00:00:00.000Z'),'UTC')}else{return this.hours(0).minutes(0).seconds(0).milliseconds(0).add(this.utcOffset(),"minute").utcOffset(0)}};return moment}))