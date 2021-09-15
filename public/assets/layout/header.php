<!-- Header section -->

<header class="header-section">
	<div class="header-background">
		<div class="header-top">
		<div class="container">
				<div class="row">
					<div class="col-lg-2">				
						<a href="/public/main.php" class="site-logo">
						    <img src="/public/assets/img/keyarlogo.png"  class="site-logo" alt="logo">	
						</a>
					</div>

					<div class="col-xl-6 col-lg-5">
					</div>
					
					<div class="col-xl-4 col-lg-5">
						<div class="user-panel painel-usuario">
							<div class="up-item">
								<div class="dropdown">
								    <i class="flaticon-profile"></i>
								    <a class="dropdown-toggle" id="menu-perfil" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil</a>
									<div class="dropdown-menu" aria-labelledby="menu-perfil">
										<?php
										// se for cliente
										if($_SESSION["idPerfil"] == Perfil::Cliente){
											echo '<a class="dropdown-item" href="/public/cliente/gerenciar_perfil.php">Gerenciar Perfil</a>
                                                  <a class="dropdown-item" href="/public/pedido/gerenciar_pedidos.php">Gerenciar Pedidos</a>';
										}
										// se for balconista
										if($_SESSION["idPerfil"] == Perfil::Balconista){
											echo '<a class="dropdown-item" href="/public/pedido/confirmar_retirada.php">Confirmar Retirada Pedido</a>
											      <a class="dropdown-item" href="/public/produto/gerenciar_itens.php">Gerenciar Produtos</a>';
										}	
										?>
										<a class="dropdown-item" href="/public/logout.php">Sair</a>
                                    </div>
                                </div>
							</div>
                            <?php
                                // se for cliente
                                if($_SESSION["idPerfil"] == Perfil::Cliente){
							        echo '<div class="up-item">
								            <div class="shopping-card">
									            <i class="flaticon-bag"></i>
								            </div>                                 
                                            <a href="/public/pedido/visualizar_pedido.php">Meu Pedido</a>';
                                    }
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>