<template>
    <div>
        <FullCalendar defaultView="dayGridMonth" :plugins="calendarPlugins"
        :events="newEvents" />
    </div>
</template>

<script>

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'

export default {
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarPlugins: [ dayGridPlugin ],
      eventsData: [],
      newEvents: []
    }
  },
  mounted() {
        var self = this;
        axios.get('/api/orders').then(
            response => {
                // console.log(response.data);
                self.eventsData = response.data;
                for(var i = 0; i <= self.eventsData.length; i++){

                    if(self.eventsData[i]){
                        self.newEvents.push({
                            title: self.eventsData[i].address,
                            date: self.eventsData[i].option_6_1 != null ? self.eventsData[i].option_6_1 : self.eventsData[i].option_7_1
                        });
                    }
                }
        }).catch(function (error) {
            console.log(error);
        });
    }
}

</script>

<style lang='scss'>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

.fc-view-container{
    background-color: #fff;
}

</style>