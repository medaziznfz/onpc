@if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2))
          <div class="grade-container d-flex justify-content-center flex-grow-1">
            @if(Auth::user()->grade)
              <div class="grade-display p-2 px-4 d-flex align-items-center flex-wrap" style=" 
                @if(Auth::user()->role == 1)
                  background-color:rgb(255, 208, 245);
                @elseif(Auth::user()->role == 2)
                  background-color:rgb(255, 133, 133);
                @endif
                border-radius: 4px;
                max-width: fit-content;
                height: fit-content;
                gap: 18px;
              ">
                <!-- Grade image: smaller and not rounded -->
                <img src="{{ asset(Auth::user()->grade->image_path) }}" alt="Grade Image" style="max-width: 28px; max-height: 28px;">
                <div class="grade-text">
                  @if(Auth::user()->role == 1)
                    جهوي 
                  @elseif(Auth::user()->role == 2)
                    مركزي 
                  @endif
                </div>
              </div>
            @endif
          </div>
        @endif