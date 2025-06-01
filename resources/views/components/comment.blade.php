<!-- Comments Section -->
                <div class="max-w-7xl mx-auto px-4 mt-10">
                    <div class="flex flex-col md:flex-row md:gap-8">
                        <!-- Comments List (Left, 50%) -->
                        <div class="md:w-1/2 w-full text-[11px]">
                            <h2 class="text-base font-bold mb-4 flex items-center gap-2 text-blue-700">
                                <i class="fas fa-comments"></i> Commentaires
                            </h2>
                            @if(isset($item->comments) && $item->comments->count())
                                <div x-data="{ showAll: false }" class="space-y-3 mb-4">
                                    @foreach($item->comments as $i => $comment)
                                        <div class="bg-gray-50 rounded-lg p-3 shadow flex flex-col" x-show="showAll || {{ $i }} < 3">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-semibold text-gray-800 text-[11px]">{{ $comment->user->name ?? 'Utilisateur' }}</span>
                                                <span class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div class="text-yellow-500 mb-1 text-[10px]">
                                                @for($j = 0; $j < $comment->rating; $j++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @for($j = $comment->rating; $j < 5; $j++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                            <div class="text-gray-700 text-[11px]">{{ $comment->content }}</div>
                                        </div>
                                    @endforeach
                                    @if($item->comments->count() > 3)
                                        <button x-show="!showAll" @click="showAll = true" class="mt-2 text-blue-600 hover:underline text-[10px] font-semibold">Afficher plus de commentaires</button>
                                    @endif
                                </div>
                            @else
                                <div class="text-gray-500 mb-6 text-[11px]">Aucun commentaire pour cette annonce.</div>
                            @endif
                        </div>
                        <!-- Add Comment Form (Right, 50%) -->
                        <div class="md:w-1/2 w-full md:pl-8 flex flex-col text-[11px]" id="ajouter-commentaire">
                            <h3 class="text-sm font-semibold mb-2 flex items-center"><i class="fas fa-pen text-blue-400 mr-2"></i>Écrire un commentaire</h3>
                            @auth
                            <div class="bg-white rounded-xl shadow p-4 mb-4">
                                <form method="POST" action="{{ route('comments.store', $item->id) }}">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="block font-medium mb-1 text-[11px]">Note</label>
                                        <div class="flex items-center gap-1" x-data="{ rating: 0 }">
                                            <template x-for="star in 5" :key="star">
                                                <button type="button" @click.prevent="rating = star" @mouseover="rating = star" @mouseleave="rating = $refs.input.value" :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'" class="focus:outline-none">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                                                </button>
                                            </template>
                                            <input x-ref="input" type="hidden" name="rating" x-model="rating" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="block font-medium mb-1 text-[11px]">Commentaire</label>
                                        <textarea name="content" required class="w-full border rounded px-2 py-1 text-[11px]" rows="3" placeholder="Votre commentaire..."></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-[10px] w-auto min-w-0">
                                            Publier le commentaire
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mb-6 text-[11px]">
                                    <i class="fas fa-info-circle mr-2"></i> <a href="{{ route('login') }}" class="underline">Connectez-vous</a> pour écrire un commentaire.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
