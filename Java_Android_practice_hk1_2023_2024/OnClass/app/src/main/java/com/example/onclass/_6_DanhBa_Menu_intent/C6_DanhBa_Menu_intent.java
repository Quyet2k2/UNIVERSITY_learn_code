package com.example.onclass._6_DanhBa_Menu_intent;

import android.content.DialogInterface;
import android.content.Intent;
import android.database.DataSetObserver;
import android.os.Bundle;
import android.os.Parcelable;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;

public class C6_DanhBa_Menu_intent extends AppCompatActivity {

    private static int vi_tri = -1;
    private MenuItem viewMenuItem, btnDeleteAllItem;
    private Button btnAdd, btnUpdate;
    private EditText editName, editContact;
    private ListView listContact;
    private ArrayList<C6_DanhBa> contactArrayList;
    private C6_List_DanhBa_Adapter c6ListDanhBaAdapter;

    public static void setVi_tri(int vi_tri) {
        C6_DanhBa_Menu_intent.vi_tri = vi_tri;
    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c6_danh_ba_list_view_custom);
        anhXa();
        c6ListDanhBaAdapter = new C6_List_DanhBa_Adapter(this, R.layout.activity_c6_danh_ba_item, contactArrayList);
        listContact.setAdapter(c6ListDanhBaAdapter);

        c6ListDanhBaAdapter.registerDataSetObserver(new DataSetObserver() {
            @Override
            public void onChanged() {
                btnDeleteAllItem.setEnabled(contactArrayList.size() != 0);
                viewMenuItem.setEnabled(false);
            }
        });
//        Lấy dữ liệu và thêm vào danh sách
        btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String name = editName.getText().toString();
                String phone = editContact.getText().toString();
                contactArrayList.add(new C6_DanhBa(name, phone));
                c6ListDanhBaAdapter.notifyDataSetChanged();
                editName.setText("");
                editContact.setText("");
            }
        });

        listContact.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                try {
                    editName.setText(contactArrayList.get(i).getTxtName());
                    editContact.setText(contactArrayList.get(i).getTxtNumber());
                    vi_tri = i;
                    viewMenuItem.setEnabled(true);
                } catch (Exception e) {
                    Toast.makeText(C6_DanhBa_Menu_intent.this, "click item listView " + e.getMessage(), Toast.LENGTH_SHORT).show();
                    System.out.println("click item listView " + e.getMessage());
                }
            }
        });

        btnUpdate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                C6_DanhBa contact = new C6_DanhBa(editName.getText().toString(), editContact.getText().toString());
                contactArrayList.set(vi_tri, contact);
                c6ListDanhBaAdapter.notifyDataSetChanged();
                viewMenuItem.setEnabled(false);
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.c6_pop_up_danh_ba_menu, menu);
        viewMenuItem = menu.findItem(R.id.btnViewItem);
        btnDeleteAllItem = menu.findItem(R.id.btnDeleteAllItem);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        try {
            if (item.getItemId() == R.id.btnViewItem) {
                Intent intent = new Intent(this, C6_Main2_next_intent.class);
                intent.putExtra("contact", (Parcelable) contactArrayList.get(vi_tri));
                startActivity(intent);
                editName.setText("");
                editContact.setText("");
            }
            if (item.getItemId() == R.id.btnDeleteAllItem) {
                AlertDialog.Builder builder = new AlertDialog.Builder(C6_DanhBa_Menu_intent.this).setMessage("Bạn có muốn xóa tất cả phẩn tử trong danh sách không?").setPositiveButton("Có", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        contactArrayList.clear();
                        c6ListDanhBaAdapter.notifyDataSetChanged();
                    }
                }).setNegativeButton("Không", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        dialogInterface.dismiss();
                    }
                });
                AlertDialog alertDialog = builder.create();
                alertDialog.show();

            }
        } catch (Exception e) {
            Toast.makeText(this, "menu item click" + e.getMessage(), Toast.LENGTH_SHORT).show();
        }
        return true;
    }


    private void anhXa() {
        btnAdd = findViewById(R.id.btnAdd);
        btnUpdate = findViewById(R.id.btnUpdate);
        editName = findViewById(R.id.editName);
        editContact = findViewById(R.id.editContact);
        listContact = findViewById(R.id.listContact);
        contactArrayList = new ArrayList<>();
        contactArrayList.add(new C6_DanhBa("Pham Van Quyet", "0123456789"));
    }
}
