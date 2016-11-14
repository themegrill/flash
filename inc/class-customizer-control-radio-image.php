<?php
class Flash_Image_Radio_Control extends WP_Customize_Control {

	public function render_content() {
		if ( empty( $this->choices ) )
			return;

			$name = '_customize-radio-' . $this->id;

			?>
			<style>
				#flash-img-container .flash-radio-img-img {
					border: 3px solid #DEDEDE;
					margin: 0 5px 5px 0;
					cursor: pointer;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
					width: 50px;
    				height: 50px;
				}
				#flash-img-container label{
					display: inline-block;
					margin: 0;
				}
				#flash-img-container .flash-radio-img-selected {
					border: 3px solid #30AFB8;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
				}
				input[type=checkbox]:before {
					content: '';
					margin: -3px 0 0 -4px;
				}
			</style>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="controls" id="flash-img-container">
			<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ($this->value() == $value)?'flash-radio-img-selected flash-radio-img-img':'flash-radio-img-img';
					?>
					<li style="display: inline;">
					<label>
						<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<img src = '<?php echo esc_url( $label ); ?>' class = '<?php echo esc_attr( $class ); ?>' />
					</label>
					</li>
					<?php
				endforeach;
			?>
			</ul>
			<script type="text/javascript">

				jQuery(document).ready(function($) {
					$('.controls#flash-img-container li img').click(function(){
						$('.controls#flash-img-container li').each(function(){
							$(this).find('img').removeClass ('flash-radio-img-selected') ;
						});
						$(this).addClass ('flash-radio-img-selected') ;
					});
				});

			</script>
			<?php
		}
	}
