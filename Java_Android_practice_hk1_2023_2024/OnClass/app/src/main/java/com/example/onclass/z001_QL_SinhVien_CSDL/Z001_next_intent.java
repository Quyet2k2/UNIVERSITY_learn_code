package com.example.onclass.z001_QL_SinhVien_CSDL;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

public class Z001_next_intent extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_z001_next_intent);

        TextView txtName = findViewById(R.id.txtName);
        TextView txtNgaySinh = findViewById(R.id.txtNgaySinh);
        TextView txtDiaChi = findViewById(R.id.txtDiaChi);
        TextView txtGioiTinh = findViewById(R.id.txtGioiTinh);
        TextView txtTruongYeuThich = findViewById(R.id.txtTruongYeuThich);


        Intent intent = getIntent();
        Person person = intent.getParcelableExtra("person");

        txtName.setText(person.getName());
        txtNgaySinh.setText(person.getNgaySinh());
        txtDiaChi.setText(person.getDiaChi());
        if (person.getGioiTinh() == 1) {
            txtGioiTinh.setText("Nam");
        } else {
            txtGioiTinh.setText("Nữ");
        }
        txtTruongYeuThich.setText(person.getTruongYeuThich());
    }
}
