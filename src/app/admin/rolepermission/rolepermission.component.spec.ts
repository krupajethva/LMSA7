import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RolepermissionComponent } from './rolepermission.component';

describe('RolepermissionComponent', () => {
  let component: RolepermissionComponent;
  let fixture: ComponentFixture<RolepermissionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RolepermissionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RolepermissionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
