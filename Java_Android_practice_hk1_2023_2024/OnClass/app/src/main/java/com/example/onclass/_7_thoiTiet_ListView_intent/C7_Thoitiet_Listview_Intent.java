package com.example.onclass._7_thoiTiet_ListView_intent;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Parcelable;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;
import java.util.List;

public class C7_Thoitiet_Listview_Intent extends AppCompatActivity {

    private int vi_tri = -1;
    private EditText editName, editDegree;
    private Button btnAdd, btnUpdate, btnDelete, btnView;
    private List<C7_ThoiTiet> c7ThoiTietList;
    private ListView listThoiTiet;
    private C7_Adapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c7_thoi_tiet_main);
        AnhXa();

        adapter = new C7_Adapter(this, R.layout.activity_c7_thoi_tiet_item, c7ThoiTietList);
        listThoiTiet.setAdapter(adapter);

        btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                try {
                    String name = editName.getText().toString();
                    int degree = Integer.parseInt(editDegree.getText().toString().trim());

                    if (name.isEmpty() || degree > 100) {
                        Toast.makeText(C7_Thoitiet_Listview_Intent.this, "Tên không được để trống!\nNhiệt độ không được quá 100!", Toast.LENGTH_SHORT).show();
                    } else {
                        c7ThoiTietList.add(new C7_ThoiTiet(name, degree));
                        adapter.notifyDataSetChanged();
                        Toast.makeText(C7_Thoitiet_Listview_Intent.this, "Thêm thành công", Toast.LENGTH_SHORT).show();
                        editName.setText("");
                        editDegree.setText("");
                    }
                } catch (Exception e) {
                    Toast.makeText(C7_Thoitiet_Listview_Intent.this, e.getMessage().trim(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        listThoiTiet.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                try {
                    vi_tri = i;
                    editName.setText(c7ThoiTietList.get(vi_tri).getTxtName().trim());
                    editDegree.setText(Integer.toString(c7ThoiTietList.get(vi_tri).getTxtDegree()));
                } catch (Exception e) {
                    Toast.makeText(C7_Thoitiet_Listview_Intent.this, "cham con listView" + e.getMessage().trim(), Toast.LENGTH_SHORT);
                }
            }
        });
        btnUpdate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                try {
                    String name = editName.getText().toString().trim();
                    int degree = Integer.parseInt(editDegree.getText().toString().trim());

                    System.out.println(degree);
                    if (name.isEmpty() || degree > 100) {
                        Toast.makeText(C7_Thoitiet_Listview_Intent.this, "Vui lòng không để trống tên hoặc nhiệt độ không quá 100", Toast.LENGTH_SHORT).show();
                    } else {
                        c7ThoiTietList.get(vi_tri).setTxtName(name);
                        c7ThoiTietList.get(vi_tri).setTxtDegree(degree);
                        adapter.notifyDataSetChanged();
                        Toast.makeText(C7_Thoitiet_Listview_Intent.this, "Sửa thành công!", Toast.LENGTH_SHORT).show();
                        editName.setText("");
                        editDegree.setText("");
                        vi_tri = -1;
                    }
                } catch (Exception e) {
                    Toast.makeText(C7_Thoitiet_Listview_Intent.this, e.getMessage().trim(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                try {
                    AlertDialog.Builder builder = new AlertDialog.Builder(C7_Thoitiet_Listview_Intent.this);
                    builder.setMessage("Bạn có muốn xóa?").setPositiveButton("Có", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            c7ThoiTietList.remove(vi_tri);
                            adapter.notifyDataSetChanged();
                            editName.setText("");
                            editDegree.setText("");
                            vi_tri = -1;
                        }
                    }).setNegativeButton("Hủy", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            dialogInterface.dismiss();
                        }
                    });
                    AlertDialog alertDialog = builder.create();
                    alertDialog.show();

                } catch (Exception e) {
                    Toast.makeText(C7_Thoitiet_Listview_Intent.this, "delete: " + e.getMessage().trim(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        btnView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                try {
                    Intent intent = new Intent(C7_Thoitiet_Listview_Intent.this, C7_Thoitiet_Next_Intent.class);
                    intent.putParcelableArrayListExtra("thoiTietList", (ArrayList<? extends Parcelable>) c7ThoiTietList);
                    startActivity(intent);
                } catch (Exception e) {
                    Toast.makeText(C7_Thoitiet_Listview_Intent.this, "view btn: " + e.getMessage().trim(), Toast.LENGTH_SHORT).show();
                    AlertDialog.Builder builder = new AlertDialog.Builder(C7_Thoitiet_Listview_Intent.this).setMessage("Lỗi: " + e.getMessage().trim()).setNegativeButton("Hủy", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            dialogInterface.dismiss();
                        }
                    });
                    AlertDialog alertDialog = builder.create();
                    alertDialog.show();
                    System.out.println("Lỗi: " + e.getMessage().trim());
                }
            }
        });
    }

    private void AnhXa() {
        btnAdd = findViewById(R.id.btnAdd);
        btnUpdate = findViewById(R.id.btnUpdate);
        btnDelete = findViewById(R.id.btnDelete);
        btnView = findViewById(R.id.btnView);
        editName = findViewById(R.id.editName);
        editDegree = findViewById(R.id.editDegree);
        listThoiTiet = findViewById(R.id.listThoiTiet);
        c7ThoiTietList = new ArrayList<>();
        c7ThoiTietList.add(new C7_ThoiTiet("quyết", 45));
    }
}
