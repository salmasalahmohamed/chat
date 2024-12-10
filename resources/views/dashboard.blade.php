<x-app-layout>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-dropdown-link :href="route('logout')"
                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-dropdown-link>
    </form>
   <div class="container mt4">
       <div class="row">

           @if(count($users)>0)
               <div class="col-md-3">
<ul>
@foreach($users as $user)

    <li class="user-list" id="user-list" data-id="{{$user->id}}">
        <img src="{{$user->image}}">
        {{$user->name}}
        <b><sup id="{{$user->id}}-status" class="offline-status"> offline</sup></b>
    </li>
    @endforeach

</ul>
               </div>
               <div class="col-md-9">
<h3 class="start-head">
    click to start the chat
</h3>



                   <div class="chat-section">
                       <div class="chat-container">




                       </div>
                       <form  method="post"   id="chat-form">

                           <input type="text"class="border" name="message" id="message" placeholder="enter the message" required>
                           <input type="submit" value="send message" class="btn btn-primary">
                       </form>

                   </div>
               </div>
           @else
               <div class="col-md-9">
                   <h3>
                      user not found
                   </h3>
               </div>
           @endif
       </div>


   </div>
    <div>

        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                    </div>
<form id="chat-form-delete">
    @csrf
    <input type="hidden" id="delete-chat-id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                           <a><button type="submit" class="btn btn-primary" id="deletechat">delete</button></a>
                        </div>
</form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <form id="chat-form-update">
                    @csrf
                    <input type="hidden" id="update-chat-id">
                    <input type="text" id="message">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <a><button type="submit" class="btn btn-primary" id="deletechat">update</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
