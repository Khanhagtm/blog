
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="margin:15px"></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <button class="dropdown-item"  >edit</button>
                                        </li>
                                        <form action="/comments/delete" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="comment_id" >
                                            <li><button class="dropdown-item">delete</button></li>
                                        </form>
                                    </ul>
                                </div>                                
                      