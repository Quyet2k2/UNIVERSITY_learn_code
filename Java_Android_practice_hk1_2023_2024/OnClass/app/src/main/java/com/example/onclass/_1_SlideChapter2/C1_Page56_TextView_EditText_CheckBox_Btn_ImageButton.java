package com.example.onclass._1_SlideChapter2;

import android.os.Bundle;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageButton;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

public class C1_Page56_TextView_EditText_CheckBox_Btn_ImageButton extends AppCompatActivity {
    Button btn_thanh_tien, btn_tiep, btn_thong_ke;
    ImageButton btnExit;
    EditText edit_ten_kh, edit_sl_sach, edit_thanh_tien, edit_tong_so_kh, edit_tong_so_kh_VIP, edit_tong_doanh_thu;
    CheckBox cb_vip;
    int tong_kh = 0;
    int tongkh_vip = 0;
    int tong_doanhthu = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_1_page58_text_view_edit_text_check_box_btn_image_button);
        initView();

        btn_thanh_tien.setOnClickListener(view -> {
            try {
                // Mã có thể gây ra ngoại lệ
                int sl_Sach = Integer.parseInt(edit_sl_sach.getText().toString());
                int res = sl_Sach * 20000;
                if (cb_vip.isChecked()) {
                    res = (res * 9) / 10;
                }
                edit_thanh_tien.setText(String.valueOf(res));
                tong_doanhthu += res;

//           Lưu thông tin khách hàng sau khi tính tiền
                if (cb_vip.isChecked()) {
                    tong_kh++;
                    tongkh_vip++;
                } else {
                    tong_kh++;
                }
                edit_sl_sach.requestFocus();

                cb_vip.setChecked(false);
                edit_sl_sach.setText("");

            } catch (Exception e) {
                // Xử lý ngoại lệ ở đây
                edit_thanh_tien.setText(String.valueOf(e.getMessage()));
            }

        });

        btn_tiep.setOnClickListener(view -> {
            edit_ten_kh.setText("");
//            cb_vip.setChecked(false);
//            edit_sl_sach.setText("");
//
//            if (cb_vip.isChecked()) {
//                tong_kh++;
//                tongkh_vip++;
//            } else {
//                tong_kh++;
//            }
            edit_ten_kh.requestFocus();
        });

        btn_thong_ke.setOnClickListener(view -> {
            edit_tong_so_kh.setText(String.valueOf(tong_kh));
            edit_tong_doanh_thu.setText(String.valueOf(tong_doanhthu));
            edit_tong_so_kh_VIP.setText(String.valueOf(tongkh_vip));

        });

        btnExit.setOnClickListener(view -> {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setTitle("Thông báo");
            builder.setMessage("Bạn có muốn thoát ứng dụng không?");
            builder.setPositiveButton("Đồng ý", (dialogInterface, i) -> {
                dialogInterface.dismiss();
                finish(); // Kết thúc hoạt động hiện tại
            });
            builder.setNegativeButton("Hủy", (dialogInterface, i) -> {
                dialogInterface.dismiss(); // Đóng AlertDialog nếu người dùng chọn "Hủy"
            });
            builder.show();
        });

    }

    private void initView() {
        edit_ten_kh = findViewById(R.id.edit_ten_kh);
        edit_sl_sach = findViewById(R.id.edit_sl_sach);
        edit_thanh_tien = findViewById(R.id.edit_thanh_tien);
        edit_tong_so_kh = findViewById(R.id.edit_tong_so_kh);
        edit_tong_so_kh_VIP = findViewById(R.id.edit_tong_so_kh_VIP);
        edit_tong_doanh_thu = findViewById(R.id.edit_tong_doanh_thu);

        cb_vip = findViewById(R.id.cb_vip);
        btn_thong_ke = findViewById(R.id.btn_thong_ke);
        btn_thanh_tien = findViewById(R.id.btn_thanh_tien);
        btn_tiep = findViewById(R.id.btn_tiep);
        btnExit = findViewById(R.id.btnExit);
    }
}
