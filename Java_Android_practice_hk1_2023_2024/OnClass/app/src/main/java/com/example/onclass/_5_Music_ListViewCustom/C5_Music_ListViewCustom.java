package com.example.onclass._5_Music_ListViewCustom;

import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;

public class C5_Music_ListViewCustom extends AppCompatActivity {

    int vitri = -1;
    private EditText editName, editAuthor;
    private Button btnAdd, btnDelete;
    private ListView listMusic;
    private ArrayList<C5_Music> musicArrayList;
    private C5_Music_Adapter c5MusicAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c5_music_list_view_custom);
        anhXa();

        musicArrayList = new ArrayList<>();
        musicArrayList.add(new C5_Music("Chac ai do se ve", "Son Tung Mtp"));

        c5MusicAdapter = new C5_Music_Adapter(this, R.layout.activity_c5_music_item, musicArrayList);
        listMusic.setAdapter(c5MusicAdapter);

//        Thêm phần tử vào danh sách
        btnAdd.setOnClickListener(view -> {
            musicArrayList.add(new C5_Music(editName.getText().toString(), editAuthor.getText().toString(), false));
            c5MusicAdapter.notifyDataSetChanged();
            // Xóa dữ liệu từ EditText sau khi thêm vào danh sách
            editName.setText("");
            editAuthor.setText("");
        });

// Xử lý sự kiện cho nút "Xóa"
        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // Tạo danh sách để lưu trữ các bài hát được chọn để xóa
                ArrayList<C5_Music> baiHatXoa = new ArrayList<>();

                // Lặp qua danh sách bài hát và kiểm tra xem các mục nào được chọn
                for (C5_Music music : musicArrayList) {
                    if (music.getCheck()) {
                        baiHatXoa.add(music); // Thêm vào danh sách để xóa
                    }
                }
                // Xóa các bài hát được chọn khỏi danh sách chính
                musicArrayList.removeAll(baiHatXoa);
                // Cập nhật giao diện danh sách
                c5MusicAdapter.notifyDataSetChanged();
            }
        });

        listMusic.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                editName.setText(musicArrayList.get(i).getTxtName());
                editAuthor.setText(musicArrayList.get(i).getTxtAuthor());
                vitri = i;
            }
        });
//
//        listMusic.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
//            @Override
//            public boolean onItemLongClick(AdapterView<?> adapterView, View view, int i, long l) {
//                vitri = i;
//                AlertDialog.Builder builder = new AlertDialog.Builder(C5_Music_ListViewCustom.this);
//                builder.setTitle("Ban co chac chan muon sua khong?");
//                builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
//                    @Override
//                    public void onClick(DialogInterface dialogInterface, int i) {
//                        musicArrayList.set(vitri, new C5_Music(editName.getText().toString(), editAuthor.getText().toString(), musicArrayList.get(vitri).getCheck()));
//                        c5MusicAdapter.notifyDataSetChanged();
//                        dialogInterface.dismiss();
//                    }
//                });
//                AlertDialog alertDialog = builder.create();
//                alertDialog.show();
//                return false;
//            }
//        });
    }

    private void anhXa() {
        editName = findViewById(R.id.editName);
        editAuthor = findViewById(R.id.editAuthor);
        btnAdd = findViewById(R.id.btnAdd);
        btnDelete = findViewById(R.id.btnDelete);
        listMusic = findViewById(R.id.listMusic);
    }


}
