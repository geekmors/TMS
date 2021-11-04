@php
$entry_summary_item_classes ="badge badge-secondary" //;"entry-info-grp border rounded p-2 m-2";
@endphp
<script type="text/template" id="entrySummaryTemplate">
    <% for(let key in data){%>
            <div data-date-group="<%=key%>" class="entry-log-list_item mb-3">
                <div class="entry-log-list_item-head bg-light shadow p-3">
                    <div class="d-flex  justify-content-between"> 
                    <div class="spacer"></div>                           
                        <div class="summary-head-date ml-2">
                            <h4>
                            <%=toReadableDate(data[key].date)%>
                            </h4>
                        </div>
                        <span class="toggle_button-con p-2" style="position: relative;top: -11px;">
                            <button class="toggle-entry-log-entry-list btn btn-outline-dark " data-toggle="collapse" data-target="#entry-list-<%=key%>" aria-expanded="true" aria-controls="entry-list-<%=key%>">
                                <span class="fa fa-chevron-up"></span>
                            </button>
                        </span>
                    </div>
                    <div class="text-center">

                        <span class="{{$entry_summary_item_classes}}">
                            <span class="label">Day Total</span>
                            <span class="value ml-2">
                                <%= ts_format(data[key].total_hours)%>
                            </span>
                        </span>
                        <span class="{{$entry_summary_item_classes}}">

                            <span class="label">
                                <abbr title="Over Time">OT</abbr>
                            </span>
                            <span class="value ml-2">
                                <%=ts_format(data[key].ot_hours)%>
                            </span>
                        </span>
                        <span class="{{$entry_summary_item_classes}}">

                            <span class="label">
                                <abbr title="Normal Working Hours">NWH</abbr>                                
                            </span>
                            <span class="value ml-2">
                                <%=ts_format(data[key].regular_hours)%>
                            </span>
                        </span>
                        <span class="{{$entry_summary_item_classes}}">

                            <span class="label">Total Entries</span>
                            <span class="value ml-2">
                                <%=data[key].entries.length%>
                            </span>
                        </span>
                    </span>

                    
                </div>
                </div>
                <ul id="entry-list-<%=key%>" class="list-group mb-4 entry-log-list_item-entries collapse show">
                    <%for(let entry of data[key].entries){%>
                    <li class="list-group-item d-flex justify-content-around list entry-log-list_item-entries_item" data-id="<%=entry.id%>">
                        <span class="item">
                            Entry Name:
                            <input class="entry-data entry-inputs" type="text" name="entry_name" placeholder="Entery a name" value="<%=entry.entry%>" data-backup="<%=entry.entry%>">
                            <div style="display:none" class="invalid-feedback-message text-center">Entry name cannot be blank</div>
                        </span>
                        <span class="item">
                            Date: <input class="entry-data entry-inputs" type="date" name="entry_date" value="<%=entry.date_worked%>" data-backup="<%=entry.date_worked%>">
                        </span>
                        <span class="item">
                            Time Start: <input class="entry-data entry-inputs" max="<%=entry.time_out%>" step="1" type="time" name="entry_start_time" id="" value="<%=entry.time_in%>" data-backup="<%=entry.time_in%>">

                        </span>
                        <span class="item">
                            Time End: <input class="entry-data entry-inputs" min="<%=entry.time_in%>" step="1" type="time" name="entry_end_time" id="" value="<%=entry.time_out%>" data-backup="<%=entry.time_out%>">
                        </span>
                        <span class="item">
                            Total Time: <span class="entry_elapsed_time" data-backup="<%=entry.total_hours%>"><%=entry.total_hours%></span>
                        </span>
                        <button class="save btn btn-outline-primary" title="save" data-id="<%=entry.id%>" style="display:none;">
                            save
                            <span class="fa fa-save"></span>
                        </button>
                        <button data-id="<%=entry.id%>" class="cancel btn btn-outline-warning" title="cancel edits" style="display:none;">
                            cancel
                            <span class="fa fa-times">
                            </span>
                        </button>
                        <button data-id="<%=entry.id%>" class="resume btn btn-outline-success" title="resume entry">
                            Resume
                            <span class="fa fa-play"></span>
                        </button>
                    </li>
                    <%}%>
                </ul>
            </div>
        <%}%>
</script>
