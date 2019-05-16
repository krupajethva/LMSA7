import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ParentcategorylistComponent } from './parentcategorylist.component';

describe('ParentcategorylistComponent', () => {
  let component: ParentcategorylistComponent;
  let fixture: ComponentFixture<ParentcategorylistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ParentcategorylistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ParentcategorylistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
