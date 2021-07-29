<section class="section-margin">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php echo $session->getFlashdata('pesan')  ?>
      </div>

      <?php if($status_pendaftaran['status'] == 0): ?>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="pricing">
          <div class="pricing-title">
            Offline
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Rp.100.000</div>
            </div>
            <div class="pricing-details">
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Datang ke koperasi</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran tunai</div>
              </div>
            </div>
          </div>
          <div class="pricing-cta">
          <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
            <input type="hidden"name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <input type="hidden" name="status" value="2" />
            <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i class="fas fa-arrow-right"></i></a>
          </form>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-6">
        <div class="pricing">
          <div class="pricing-title">
            Online
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Rp.100.000</div>
            </div>
            <div class="pricing-details">
           
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Mengunggah bukti ransfer</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran transfer</div>
              </div>
          
              
              
            </div>
          </div>
          <div class="pricing-cta">
          <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
            
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <input type="hidden" name="status" value="1" />
            <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i class="fas fa-arrow-right"></i></a>
          </form>
          </div>
        </div>
      </div>

      <?php endif; ?>
      
      <?php if($status_pendaftaran['status'] == 1): ?>
      <div class="col-12 col-md-6 col-lg-8">
        hhhhhhhh
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="pricing">
          <div class="pricing-title">
            Offline
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Rp.100.000</div>
            </div>
            <div class="pricing-details">
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Datang ke koperasi</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran tunai</div>
              </div>
            </div>
          </div>
          <div class="pricing-cta">
          <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
            <input type="hidden"name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <input type="hidden" name="status" value="2" />
            <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i class="fas fa-arrow-right"></i></a>
          </form>
          </div>
        </div>
      </div>

     
      <?php endif; ?>

      <?php if($status_pendaftaran['status'] == 2): ?>
        <div class="col-12 col-md-6 col-lg-8">
        hhhhhhhh
        </div>
      
        <div class="col-12 col-md-6 col-lg-4">
        <div class="pricing">
          <div class="pricing-title">
            Online
          </div>
          <div class="pricing-padding">
            <div class="pricing-price">
              <div>Rp.100.000</div>
            </div>
            <div class="pricing-details">
           
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Mengunggah bukti ransfer</div>
              </div>
              <div class="pricing-item">
                <div class="pricing-item-icon bg-primary text-white">></i></div>
                <div class="pricing-item-label">Pembayaran transfer</div>
              </div>
          
              
              
            </div>
          </div>
          <div class="pricing-cta">
          <form action="<?php echo base_url().'/konfirmasi/pilih-jenis' ?>" method="post" accept-charset="utf-8">
            
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <input type="hidden" name="status" value="1" />
            <button type="submit" class="btn btn-block btn-lg btn-primary">Pilih <i class="fas fa-arrow-right"></i></a>
          </form>
          </div>
        </div>
      </div>


      <?php endif; ?>







    </div>
  </div>

</section>