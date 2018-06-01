<div class="modal fade in" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">    
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_label">Search a location</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="search_block">
                    <label for="search_address" class="control-label">Enter address to search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_address"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn_decode" type="button">Locate</button>
                        </span>
                    </div>
                </div>
                <div id="map_wrapper" style="display:none;">
                    <div class="form-group" id="result_selector_group">
                        <label for="result_selector" class="control-label">Pick the best match from <span class="label label-default" id="result_count">XXX</span> result(s)</label>
                        <select class="form-control" id="result_selector">                            
                        </select>
                    </div>
                    <div class="row address-decoded">
                        <div class="col-md-3">
                            Country
                            <span id="decoded_country">test</span>
                        </div>
                        <div class="col-md-3">
                            State
                            <span id="decoded_state"></span>
                        </div>
                        <div class="col-md-3">
                            City
                            <span id="decoded_city"></span>
                        </div>
                        <div class="col-md-3">
                            Zip code
                            <span id="decoded_zip"></span>
                        </div>
                    </div>
                    <div class="row address-decoded">
                        <div class="col-md-6">
                            Street address
                            <span id="decoded_address"></span>
                        </div>
                        <div class="col-md-3">
                            Latitude
                            <span id="decoded_geo_lat"></span>
                        </div>
                        <div class="col-md-3">
                            Longitude
                            <span id="decoded_geo_lng"></span>
                        </div>
                    </div>
                    <br>
                    <div id="map_holder"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <span></span>
                <button type="button" id="lock_address" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    #map_wrapper #map_holder{
        max-height: 300px;
        height: 300px;
    }
    .address-decoded>div>span{
        display: block;
        color: navy;
        border: 1px solid #777;
        background-color: #aaa;
        color: white;
        padding: 4px;
        min-height: 30px;
    }
    .address-decoded>div>span[data-required="false"]{
        border-color: red;
    }
</style>